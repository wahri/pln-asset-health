<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\ReportAssets;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $locations = Location::all();

        return view('pages.dashboard.index', compact('locations'));
    }

    public function getReportData(Request $request)
    {
        if ($request->location_id) {
            $latestReport = DB::table('reports')
                ->where('location_id', $request->location_id)
                ->orderBy('date', 'desc')
                ->first();

            if (!$latestReport) {
                return response()->json([
                    'categories' => [],
                    'series' => []
                ]);
            }

            // Ambil jumlah asset berdasarkan status per unit di lokasi dan report terakhir
            $reportAssetCounts = DB::table('report_assets')
                ->join('assets', 'report_assets.asset_id', '=', 'assets.id')
                ->join('units', 'assets.unit_id', '=', 'units.id')
                ->where('report_assets.report_id', $latestReport->id)
                ->select('units.name as unit_name', 'report_assets.status', DB::raw('COUNT(*) as asset_count'))
                ->groupBy('units.id', 'report_assets.status')
                ->get();

            // Strukturkan data untuk format Highcharts
            $units = [];
            $normalData = [];
            $abnormalData = [];
            $faultData = [];

            foreach ($reportAssetCounts->groupBy('unit_name') as $unitName => $statuses) {
                $units[] = $unitName;
                $normalData[] = $statuses->where('status', 'normal')->sum('asset_count') ?: 0;
                $abnormalData[] = $statuses->where('status', 'abnormal')->sum('asset_count') ?: 0;
                $faultData[] = $statuses->where('status', 'fault')->sum('asset_count') ?: 0;
            }

            $reportAsset = ReportAssets::with('asset', 'asset.assetGroup', 'report', 'unit', 'unit.location', 'detailReports')->where('report_id', $latestReport->id)->where('status', '!=', 'normal')->get();

            // Format response untuk Highcharts
            return response()->json([
                'charts' => [
                    'categories' => $units,
                    'series' => [
                        ['name' => 'Normal', 'data' => $normalData],
                        ['name' => 'Abnormal', 'data' => $abnormalData],
                        ['name' => 'Fault', 'data' => $faultData],
                    ]
                ],
                'table' => $reportAsset
            ]);
        } else {
            // Ambil report terakhir untuk setiap lokasi
            $latestReports = DB::table('reports as r1')
                ->join('locations as l', 'r1.location_id', '=', 'l.id')
                ->select('r1.location_id', 'r1.id as report_id', 'l.name as location_name')
                ->whereRaw('r1.date = (SELECT MAX(r2.date) FROM reports as r2 WHERE r2.location_id = r1.location_id)')
                ->get();
            // Ambil count asset berdasarkan status pada report terakhir setiap lokasi
            $reportAssetCounts = DB::table('report_assets')
                ->select('status', 'report_id', DB::raw('COUNT(*) as asset_count'))
                ->whereIn('report_id', $latestReports->pluck('report_id'))
                ->groupBy('report_id', 'status')
                ->get();

            // Persiapkan data untuk Highcharts
            $locations = [];
            $normalData = [];
            $abnormalData = [];
            $faultData = [];

            foreach ($latestReports as $report) {
                $locations[] = $report->location_name;

                $assets = $reportAssetCounts->where('report_id', $report->report_id);
                $normalData[] = $assets->where('status', 'normal')->sum('asset_count') ?: 0;
                $abnormalData[] = $assets->where('status', 'abnormal')->sum('asset_count') ?: 0;
                $faultData[] = $assets->where('status', 'fault')->sum('asset_count') ?: 0;
            }

            $reportAsset = ReportAssets::with('asset', 'asset.assetGroup', 'report', 'unit', 'unit.location', 'detailReports')->whereIn('report_id', $latestReports->pluck('report_id'))->where('status', '!=', 'normal')->get();

            // Format response untuk Highcharts
            return response()->json(
                [
                    'charts' => [
                        'categories' => $locations,
                        'series' => [
                            ['name' => 'Normal', 'data' => $normalData],
                            ['name' => 'Abnormal', 'data' => $abnormalData],
                            ['name' => 'Fault', 'data' => $faultData],
                        ]
                    ],
                    'table' => $reportAsset
                ]
            );
        }
    }

    public function getDataChart(Request $request)
    {

        Carbon::setLocale('id');

        $data = [];

        if ($request->id == 0) {

            // Ambil semua reportAssets dengan relasi asset, unit, location, dan report, lalu group by location name
            $reportAssets = ReportAssets::with('asset.unit.location', 'report')
                ->whereHas('report', function ($query) {
                    $query->where('date', '>=', Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d'));
                })
                ->get()
                ->groupBy(function ($item) {
                    return $item->asset->unit->location->name; // Group by location name
                });

            // Looping data yang sudah di-group untuk menambahkannya ke array $data
            foreach ($reportAssets as $locationName => $assets) {
                // Iterasi setiap aset di lokasi
                foreach ($assets as $reportAsset) {
                    // Ambil nama unit dan format tanggal dalam Bahasa Indonesia
                    $unitName = $reportAsset->asset->unit->name;
                    $date = Carbon::parse($reportAsset->report->date)->locale('id')->translatedFormat('F');

                    // Membuat key berdasarkan unit dan bulan
                    $key = $unitName . '_' . $date;

                    // Jika key belum ada, inisialisasi data untuk unit dan bulan tersebut
                    if (!isset($data[$key])) {
                        $data[$key] = [
                            'unit' => $unitName,
                            'location' => $locationName,  // Tambahkan nama lokasi
                            'normal' => 0,
                            'abnormal' => 0,
                            'fault' => 0,
                            'date' => $date,
                        ];
                    }

                    // Hitung jumlah status berdasarkan nilai reportAsset->status
                    if ($reportAsset->status === 'normal') {
                        $data[$key]['normal']++;
                    } elseif ($reportAsset->status === 'abnormal') {
                        $data[$key]['abnormal']++;
                    } elseif ($reportAsset->status === 'fault') {
                        $data[$key]['fault']++;
                    }
                }
            }

            // Ubah array menjadi numerik menggunakan array_values
            $finalData = array_values($data);

            // Jika tidak ada data, tambahkan data default
            if (empty($finalData)) {
                $finalData[] = [
                    'unit' => 'Tidak ada data',
                    'location' => 'Tidak ada lokasi',
                    'normal' => 0,
                    'abnormal' => 0,
                    'fault' => 0,
                    'date' => 'Tidak ada data',
                ];
            }


            return response()->json($finalData);
        } else {

            $reportAssets = ReportAssets::whereHas('asset.unit.location', function ($query) use ($request) {
                $query->where('id', '=', $request->id);
            })->with('asset.unit.location')->get();


            foreach ($reportAssets as $reportAsset) {
                $unitName = $reportAsset->asset->unit->name;
                $date = Carbon::parse($reportAsset->report->date)->locale('id')->translatedFormat('F');

                $key = $unitName . '_' . $date;

                if (! isset($data[$key])) {
                    $data[$key] = [
                        'unit' => $unitName,
                        'normal' => 0,
                        'abnormal' => 0,
                        'fault' => 0,
                        'date' => $date,
                    ];
                }

                if ($reportAsset->status === 'normal') {
                    $data[$key]['normal']++;
                } elseif ($reportAsset->status === 'abnormal') {
                    $data[$key]['abnormal']++;
                } elseif ($reportAsset->status === 'fault') {
                    $data[$key]['fault']++;
                }
            }

            $finalData = array_values($data);

            if (empty($finalData)) {
                $finalData[] = [
                    'unit' => 'Tidak ada data',
                    'normal' => 0,
                    'abnormal' => 0,
                    'fault' => 0,
                    'date' => 'Tidak ada data',
                ];
            }

            return response()->json($finalData);
        }
    }
}
