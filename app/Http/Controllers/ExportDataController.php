<?php

namespace App\Http\Controllers;

use App\Models\DetailReport;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Exports\MultipleSheetsExport;
use App\Models\ReportAssets;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ExportDataController extends Controller
{
    public function index()
    {
        $locations = Location::all();

        return view('pages.export-data.index', compact('locations'));
    }

    public function show(Request $request)
    {
        $locations = Location::all();
        $bulan = $request->bulan . '-01';
        $lokasi_id = $request->location;
        $overview = [];
        $unit = [];
        $detailWarnings = [];
        $detailFaults = [];
        $namaUnit = [];




        $reportAssets = ReportAssets::with('asset', 'asset.assetGroup', 'report', 'unit', 'unit.location', 'detailReports')
            ->whereHas('report', function ($query) use ($bulan) {
                $query->where('date', $bulan);
            })
            ->whereHas('asset', function ($query) {
                $query->where('is_active', 1);
            })
            ->whereHas('unit', function ($query) use ($lokasi_id) {
                $query->where('location_id', $lokasi_id);
            })->get();

        $overview = [];
        $unit =  [];
        $detailWarnings = [];
        $detailFaults = [];

        $assetsGroupedByUnit = $reportAssets->groupBy(function ($reportAsset) {
            return $reportAsset->asset->unit->id; // Group by unit ID
        });


        foreach ($assetsGroupedByUnit as $assetsUnit) {
            $overview[] = [
                'unit' => $assetsUnit->first()->unit->name,
                'total' => $assetsUnit->count(),
                'normal' => $assetsUnit->where('status', 'normal')->count() ?: '0',
                'warning' => $assetsUnit->where('status', 'abnormal')->count() ?: '0',
                'fault' => $assetsUnit->where('status', 'fault')->count() ?: '0',
                'normalPersen' => $assetsUnit->count() ? number_format(($assetsUnit->where('status', 'normal')->count() * 100 / $assetsUnit->count()), 2, ',', '') : '0,00',
                'warningPersen' => $assetsUnit->count() ? number_format(($assetsUnit->where('status', 'abnormal')->count() * 100 / $assetsUnit->count()), 2, ',', '') : '0,00',
                'faultPersen' => $assetsUnit->count() ? number_format(($assetsUnit->where('status', 'fault')->count() * 100 / $assetsUnit->count()), 2, ',', '') : '0,00',
                'assetWarning' => $assetsUnit->filter(function ($asset) {
                    return $asset->status == 'abnormal';
                })->pluck('asset.name')->unique()->implode("\n"),
                'assetFault' => $assetsUnit->filter(function ($asset) {
                    return $asset->status == 'fault';
                })->pluck('asset.name')->unique()->implode("\n"),

            ];
        }





        // Query DetailReport berdasarkan parameter bulan dan lokasi
        $detailReports = DetailReport::with([
            'reportAsset',
            'reportAsset.report',
            'reportAsset.asset.unit',
            'reportAsset.asset.assetGroup',
            'reportAsset.asset.unit.location',
        ])
            ->whereHas('reportAsset.report', function ($query) use ($bulan) {
                $query->where('date', $bulan);
            })
            ->when($lokasi_id != 0, function ($query) use ($lokasi_id) {
                $query->whereHas('reportAsset.asset.unit.location', function ($query) use ($lokasi_id) {
                    $query->where('id', $lokasi_id);
                });
            })
            ->get();



        // Group assets by unit
        $assetsGroupedByUnit = $detailReports->groupBy(function ($item) {
            return $item->reportAsset->asset->unit->id; // Group by unit ID
        });

        // Loop through each unit to calculate counts
        foreach ($assetsGroupedByUnit as $unitId => $assets) {
            // Get unit name
            $currentUnit = $assets->first()->reportAsset->asset->unit;

            $totalCount = $assets->count();
            $normalCount = $assets->where('reportAsset.status', 'normal')->count();
            $warningCount = $assets->where('reportAsset.status', 'abnormal')->count();
            $faultCount = $assets->where('reportAsset.status', 'fault')->count();

            // Kumpulkan nama aset untuk 'warning' dan 'fault' tanpa duplikasi untuk setiap unit
            $assetWarning = $assets->filter(function ($report) {
                return $report->reportAsset->status == 'abnormal';
            })->pluck('reportAsset.asset.name')->unique()->implode("\n");

            $assetFault = $assets->filter(function ($report) {
                return $report->reportAsset->status == 'fault';
            })->pluck('reportAsset.asset.name')->unique()->implode("\n");

           

            // Additional details for each asset in the unit
            foreach ($assets as $value) {
                // Cek jika nama unit belum ada dalam array $unit
                if (!in_array($currentUnit->name, array_column($unit, 'unit'))) {
                    $unit[] = [
                        'unit' => $currentUnit->name,
                        'system' => $value->reportAsset->asset->assetGroup->name,
                        'noAsset' => $value->reportAsset->asset->no_asset,
                        'equipment' => $value->reportAsset->asset->name,
                        // 'status' => $value->reportAsset->status,
                    ];
                }

                // Isi $detailWarnings atau $detailFaults sesuai status
                $details = [
                    'unit' => $currentUnit->name,
                    'noAsset' => $value->reportAsset->asset->no_asset,
                    'noSR' => $value->no_sr,
                    'noWO' => $value->no_wo,
                    'tanggalIdentifikasi' => $value->tanggal_identifikasi,
                    'statusSaatIni' => $value->status_sr,
                    'kondisiAsset' => $value->kondisi_asset,
                    'actionPlan' => $value->action_plan,
                    'targetSelesai' => $value->target_selesai,
                    'progresSaatIni' => $value->progress_saat_ini,
                    'realisasiSelesai' => $value->realisasi_selesai,
                    'issue' => $value->issue,
                    'keterangan' => $value->keterangan
                ];

                if ($value->reportAsset->status == 'abnormal') {
                    $detailWarnings[] = $details;
                } elseif ($value->reportAsset->status == 'fault') {
                    $detailFaults[] = $details;
                }
            }
        }



        return Excel::download(new MultipleSheetsExport($bulan, $lokasi_id, $overview, $unit, $detailWarnings, $detailFaults, $namaUnit), 'Asset Health PLTA ' . Carbon::parse($bulan)->translatedFormat('F Y') . '-' . Location::find($lokasi_id)->name . '.xlsx');

       
    }
}
