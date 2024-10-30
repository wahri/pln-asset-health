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
        $lokasi = $request->location;
        $overview = [];
        $unit = [];
        $detailWarnings = [];
        $detailFaults = [];
        $namaUnit = [];

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
            ->when($lokasi != 0, function ($query) use ($lokasi) {
                $query->whereHas('reportAsset.asset.unit.location', function ($query) use ($lokasi) {
                    $query->where('id', $lokasi);
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

            // Store data in overview
            $overview[] = [
                'unit' => $currentUnit->name,
                'total' => $totalCount,
                'normal' => $normalCount,
                'warning' => $warningCount,
                'fault' => $faultCount,
                'normalPersen' => $totalCount ? number_format(($normalCount * 100 / $totalCount), 2, ',', '') : '0,00',
                'warningPersen' => $totalCount ? number_format(($warningCount * 100 / $totalCount), 2, ',', '') : '0,00',
                'faultPersen' => $totalCount ? number_format(($faultCount * 100 / $totalCount), 2, ',', '') : '0,00',
                'assetWarning' => $assetWarning,
                'assetFault' => $assetFault,
            ];

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

       

        return Excel::download(new MultipleSheetsExport($bulan, $lokasi, $overview, $unit, $detailWarnings, $detailFaults, $namaUnit), 'Asset Health PLTA ' . Carbon::parse($bulan)->translatedFormat('F Y') . '-' . Location::find($lokasi)->name . '.xlsx');

        return view('pages.export-data.index', [
            'location' => $location ?? '', // Set default to prevent error if location is not defined
            'unit' => $unit,
            'detailWarnings' => $detailWarnings,
            'detailFaults' => $detailFaults,
            'locations' => $locations,
            'namaUnit' => $namaUnit
        ]);
    }



}
