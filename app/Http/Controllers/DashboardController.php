<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\ReportAssets;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

        $data = [];  // Array untuk menyimpan data akhir

        // Cek jika ID lokasi ada dalam permintaan
        if ($request->id) {
            // Ambil data ReportAssets berdasarkan ID lokasi
            $reportAssets = ReportAssets::whereHas('asset.unit.location', function ($query) use ($request) {
                $query->where('id', '=', $request->id);
            })->with('asset.unit.location')->get();
        } else {
            // Jika ID tidak diberikan, ambil semua ReportAssets
            $reportAssets = ReportAssets::with('asset.unit.location')->with('report')->get();

            // $reportAssets = ReportAssets::whereHas('asset.unit.location', function ($query) {
            //     $query->where('id', '=', 3);
            // })->with('asset.unit.location')->get();
        }

        // Mengelompokkan data berdasarkan unit dan bulan
        foreach ($reportAssets as $reportAsset) {
            $unitName = $reportAsset->asset->unit->name;
            $date = Carbon::parse($reportAsset->report->date)->locale('id')->translatedFormat('F');

            // Membangun kunci berdasarkan unit dan bulan
            $key = $unitName . '_' . $date;

            // Inisialisasi jika kunci belum ada
            if (!isset($data[$key])) {
                $data[$key] = [
                    'unit' => $unitName,
                    'normal' => 0,
                    'abnormal' => 0,
                    'fault' => 0,
                    'date' => $date,
                ];
            }

            // Increment status berdasarkan status laporan
            if ($reportAsset->status === 'normal') {
                $data[$key]['normal']++;
            } elseif ($reportAsset->status === 'abnormal') {
                $data[$key]['abnormal']++;
            } elseif ($reportAsset->status === 'fault') {
                $data[$key]['fault']++;
            }
        }

        // Mengubah data dari array asosiatif ke array numerik
        $finalData = array_values($data);

        // Menambahkan kondisi jika tidak ada data ditemukan
        if (empty($finalData)) {
            $finalData[] = [
                'unit' => 'Tidak ada data',
                'normal' => 0,
                'abnormal' => 0,
                'fault' => 0,
                'date' => 'Tidak ada data',
            ];
        }


        

        // Mengembalikan data dalam format JSON
        return response()->json($finalData);
    }
}
