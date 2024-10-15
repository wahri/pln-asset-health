<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\ReportAssets;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $locations = Location::all();

        return view('pages.dashboard.index', compact('locations'));
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
