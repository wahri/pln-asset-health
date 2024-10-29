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

        // Loop untuk membagi data ke dalam $unit, $detailWarnings, dan $detailFaults
        foreach ($detailReports as $value) {
            $location = $value->reportAsset->asset->unit->location->name;

            // Cek jika nama unit belum ada dalam array
            if (!in_array($value->reportAsset->asset->unit->name, array_column($namaUnit, 'unit'))) {
                $namaUnit[] = [
                    'id' => $value->reportAsset->asset->unit->id,
                    'unit' => $value->reportAsset->asset->unit->name
                ];
            }



            // Isi $unit array
            $unit[] = [
                'unit' => $value->reportAsset->asset->unit->name,
                'system' => $value->reportAsset->asset->assetGroup->name,
                'noAsset' => $value->reportAsset->asset->no_asset,
                'equipment' => $value->reportAsset->asset->name,
                'status' => $value->reportAsset->status,
            ];

            // Isi $detailWarnings atau $detailFaults sesuai status
            $details = [
                // 'status' => $value->reportAsset->status,
                'unit' => $value->reportAsset->asset->unit->name,
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


        $reportAsset = ReportAssets::with(['report', 'asset', 'asset.unit', 'asset.unit.location'])
            ->whereHas('report', function ($query) use ($bulan) {
                $query->where('date', $bulan);
            })
            ->when($lokasi != 0, function ($query) use ($lokasi) {
                $query->whereHas('asset.unit.location', function ($query) use ($lokasi) {
                    $query->where('id', $lokasi);
                });
            })
            ->get();


        return Excel::download(new MultipleSheetsExport($bulan, $lokasi, $unit, $detailWarnings, $detailFaults, $namaUnit), 'Asset Health PLTA ' . Carbon::parse($bulan)->translatedFormat('F Y') . '-' . Location::find($lokasi)->name . '.xlsx');

        return view('pages.export-data.index', [
            'location' => $location,
            'unit' => $unit,
            'detailWarnings' => $detailWarnings,
            'detailFaults' => $detailFaults,
            'locations' => $locations,
            'namaUnit' => $namaUnit
        ]);
    }
}
