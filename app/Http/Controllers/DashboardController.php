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



            // Fetch monthly report data
            $monthlyReportData = DB::table('report_assets')
            ->join('assets', 'report_assets.asset_id', '=', 'assets.id')
                ->join('units', 'assets.unit_id', '=', 'units.id')
                ->join('reports', 'report_assets.report_id', '=', 'reports.id')
                ->where('reports.location_id', $request->location_id)
                ->select('units.name as unit_name', 'report_assets.status', DB::raw('COUNT(*) as asset_count'), DB::raw('MONTH(reports.date) as report_month'))
                ->groupBy('units.id', 'report_assets.status', 'report_month')
                ->get();

            // Initialize the monthly data structure with zeroes
            $months = array_reverse([
                '01' => 'Januari',
                '02' => 'Februari',
                '03' => 'Maret',
                '04' => 'April',
                '05' => 'Mei',
                '06' => 'Juni',
                '07' => 'Juli',
                '08' => 'Agustus',
                '09' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Desember',
            ]);

            $monthlyData = [];
            foreach ($months as $monthCode => $monthName) {
                $monthlyData[$monthName] = [
                    'Normal' => [],
                    'Abnormal' => [],
                    'Fault' => [],
                ];
            }

            // Populate the monthly data based on the fetched results
            foreach ($monthlyReportData as $report) {
                $monthName = $months[str_pad($report->report_month, 2, '0', STR_PAD_LEFT)];
                $unitName = $report->unit_name;

                if ($report->status == 'normal') {
                    $monthlyData[$monthName]['Normal'][$unitName] = $report->asset_count ?: 0;
                } elseif ($report->status == 'abnormal') {
                    $monthlyData[$monthName]['Abnormal'][$unitName] = $report->asset_count ?: 0;
                } elseif ($report->status == 'fault') {
                    $monthlyData[$monthName]['Fault'][$unitName] = $report->asset_count ?: 0;
                }
            }

            // Prepare headers using units related to the selected location
            $units = DB::table('units')->where('location_id', $request->location_id)->get();
            $monthlyReport = [
                'headers' => array_map(function ($unit) {
                    return [
                        'location' => $unit->name,
                        'columns' => ['Normal', 'Abnormal', 'Fault'],
                    ];
                }, $units->toArray()),
                'data' => $monthlyData,
            ];

            $month = array_reverse([
                '01' => 'Januari',
                '02' => 'Februari',
                '03' => 'Maret',
                '04' => 'April',
                '05' => 'Mei',
                '06' => 'Juni',
                '07' => 'Juli',
                '08' => 'Agustus',
                '09' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Desember',
            ]);


            $chartData = [
                'categories' => array_values($month), // Bulan sebagai label X
                'series' => [
                    ['name' => 'Normal', 'data' => []],
                    ['name' => 'Abnormal', 'data' => []],
                    ['name' => 'Fault', 'data' => []],
                ],
            ];

            foreach ($months as $monthCode => $monthName) {
                $chartData['series'][0]['data'][] = isset($monthlyData[$monthName]['Normal']) ? array_sum($monthlyData[$monthName]['Normal']) : 0;
                $chartData['series'][1]['data'][] = isset($monthlyData[$monthName]['Abnormal']) ? array_sum($monthlyData[$monthName]['Abnormal']) : 0;
                $chartData['series'][2]['data'][] = isset($monthlyData[$monthName]['Fault']) ? array_sum($monthlyData[$monthName]['Fault']) : 0;
            }

          


            // Format response untuk Highcharts
            return response()->json([
                'charts' => [
                    'categories' =>
                    $units->pluck('name')->toArray(),
                    'series' => [
                        ['name' => 'Normal', 'data' => $normalData],
                        ['name' => 'Abnormal', 'data' => $abnormalData],
                        ['name' => 'Fault', 'data' => $faultData],
                    ]
                ],
                'table' => $reportAsset,
                'monthlyReport' => $monthlyReport ,
                'trendLineChart' => $chartData
            ]);
        } else {
            // Ambil laporan terakhir untuk setiap lokasi
            $latestReports = DB::table('reports as r1')
                ->join('locations as l', 'r1.location_id', '=', 'l.id')
                ->select('r1.location_id', 'r1.id as report_id', 'l.name as location_name', DB::raw('MONTH(r1.date) as report_month'))
                ->whereRaw('r1.date = (SELECT MAX(r2.date) FROM reports as r2 WHERE r2.location_id = r1.location_id)')
                ->get();

            // Siapkan data untuk tiap bulan dan lokasi
            // Urutan bulan dimulai dari Desember ke Januari
            $months = array_reverse(['01' => 'Januari',
                '02' => 'Februari',
                '03' => 'Maret',
                '04' => 'April',
                '05' => 'Mei',
                '06' => 'Juni',
                '07' => 'Juli',
                '08' => 'Agustus',
                '09' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Desember',
            ]);
            $locations = $latestReports->pluck('location_name')->unique()->toArray();
            $monthlyData = [];

            // Inisialisasi data untuk tiap bulan dan lokasi
            foreach ($months as $month => $monthName) {
                $monthlyData[$monthName] = [];
                foreach ($locations as $location) {
                    $monthlyData[$monthName][$location] = [
                        'Normal' => 0,
                        'Abnormal' => 0,
                        'Fault' => 0,
                    ];
                }
            }
            // Ambil data report assets berdasarkan status dan lokasi
            $reportAssetCounts = DB::table('report_assets')
                ->join('reports', 'report_assets.report_id', '=', 'reports.id')
                ->join('locations', 'reports.location_id', '=', 'locations.id')
                ->select('locations.name as location_name', 'report_assets.status', DB::raw('COUNT(*) as asset_count'), DB::raw('MONTH(reports.date) as report_month'))
                ->groupBy('locations.name', 'report_assets.status', 'report_month')
                ->get();

            // Mengisi data ke dalam $monthlyData sesuai bulan dan status
            foreach ($reportAssetCounts as $report) {
                $monthName = $months[str_pad($report->report_month, 2, '0', STR_PAD_LEFT)];
                $location = $report->location_name;

                if ($report->status == 'normal') {
                    $monthlyData[$monthName][$location]['Normal'] = $report->asset_count;
                } elseif ($report->status == 'abnormal') {
                    $monthlyData[$monthName][$location]['Abnormal'] = $report->asset_count;
                } elseif ($report->status == 'fault') {
                    $monthlyData[$monthName][$location]['Fault'] = $report->asset_count;
                }
            }

            // Persiapkan data untuk monthlyReport sesuai dengan struktur yang diinginkan
            $monthlyReportData = [];
            $chartData =  [];
            foreach ($monthlyData as $month => $locationsData) {
                $dataRow = ['month' => $month];
                foreach ($locations as $location) {
                    $dataRow[strtolower(str_replace(' ', '', $location))] = [
                        $locationsData[$location]['Normal'],
                        $locationsData[$location]['Abnormal'],
                        $locationsData[$location]['Fault'],
                    ];
                }
                $chartDataRow = ['month' => $month];
                
                $monthlyReportData[] = $dataRow;
            }



            // Persiapkan data untuk Highcharts
            $normalData = [];
            $abnormalData = [];
            $faultData = [];

            foreach ($latestReports as $report) {
                $assets = $reportAssetCounts->where('location_name', $report->location_name);
                $normalData[] = $assets->where('status', 'normal')->sum('asset_count') ?: 0;
                $abnormalData[] = $assets->where('status', 'abnormal')->sum('asset_count') ?: 0;
                $faultData[] = $assets->where('status', 'fault')->sum('asset_count') ?: 0;
            }

            // Ambil data report assets berdasarkan status pada report terakhir setiap lokasi
            $reportAsset = ReportAssets::with('asset', 'asset.assetGroup', 'report', 'unit', 'unit.location', 'detailReports')
                ->whereIn('report_id', $latestReports->pluck('report_id'))
                ->where('status', '!=', 'normal')
                ->get();

            // Format response untuk Highcharts dan tambahan data bulanan


            // trend line chart data

            $month =[
                '01' => 'Januari',
                '02' => 'Februari',
                '03' => 'Maret',
                '04' => 'April',
                '05' => 'Mei',
                '06' => 'Juni',
                '07' => 'Juli',
                '08' => 'Agustus',
                '09' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Desember',
            ];

            $chartData = [
                'categories' => array_values($month), // Bulan sebagai label X
                'series' => [
                    ['name' => 'Normal', 'data' => []],
                    ['name' => 'Abnormal', 'data' => []],
                    ['name' => 'Fault', 'data' => []],
                ],
            ];

            foreach ($month as $monthName) {
                $normalSum = 0;
                $abnormalSum = 0;
                $faultSum = 0;

                foreach ($locations as $location) {
                    $normalSum += $monthlyData[$monthName][$location]['Normal'];
                    $abnormalSum += $monthlyData[$monthName][$location]['Abnormal'];
                    $faultSum += $monthlyData[$monthName][$location]['Fault'];
                }

                $chartData['series'][0]['data'][] = $normalSum;   // Data untuk status "Normal"
                $chartData['series'][1]['data'][] = $abnormalSum; // Data untuk status "Abnormal"
                $chartData['series'][2]['data'][] = $faultSum;   // Data untuk status "Fault"
            }

      

            return response()->json([
                'charts' => [
                    'categories' => $locations,
                    'series' => [
                        ['name' => 'Normal', 'data' => $normalData],
                        ['name' => 'Abnormal', 'data' => $abnormalData],
                        ['name' => 'Fault', 'data' => $faultData],
                    ]
                ],

                'table' => $reportAsset, // Menyediakan data untuk tabel yang lama
                // 'monthlyReport' => [
                //     'categories' => $locations,
                //     'series' => $monthlyData
                // ],

                'monthlyReport' => [
                    'headers' => array_map(function ($location) {
                        return [
                            'location' => $location,
                            'columns' => ['Normal', 'Abnormal', 'Fault'],
                        ];
                    }, $locations),
                    'data' => $monthlyReportData,
                   
                ],
                'trendLineChart' => $chartData
            ]);
        }
    }

    public function chartAsset($locationId){
        return 1;
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
