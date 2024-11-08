<?php

namespace App\Imports;

use App\Models\Asset;
use App\Models\DetailReport;
use App\Models\Location;
use App\Models\Report;
use App\Models\ReportAssets;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class ReportImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $headers = [
            'location',
            'month_year',
            'no_asset',
            'status',
            'no_sr',
            'no_wo',
            'tgl_identifikasi',
            'status_saat_ini',
            'kondisi_asset',
            'action_plan',
            'target_selesai',
            'progress_saat_ini',
            'realisasi_selesai',
            'main_issue',
            'keterangan'
        ];

        if (count($row) >= count($headers) && !array_diff($headers, $row)) {
            return null;
        }
        $location = Location::where('name', $row[0])->first();

        if (!$location) {
            return null;
        }

        $checkReportDate = Report::where('location_id', $location->id)
            ->where('date', $this->convertMonth($row[1], $row))
            ->first();
        
        if (!$checkReportDate) {
            $report = Report::firstOrCreate([
                'location_id' => $location->id,
                'date' => $this->convertMonth($row[1], $row)
            ]);

            $units = Unit::where('location_id', $location->id)->get();

            foreach ($units as $unit) {
                $assets = Asset::where('unit_id', $unit->id)->get();

                foreach ($assets as $asset) {
                    ReportAssets::updateOrCreate(
                        [
                            'report_id' => $report->id,
                            'unit_id' => $asset->unit_id,
                            'asset_id' => $asset->id,
                            'status' => 'normal',
                        ],
                    );
                }
            }
        } else {
            $report = $checkReportDate;
        }

        $asset = Asset::with('unit.location')
            ->whereHas('unit', function ($query) use ($location) {
                $query->where('location_id', $location->id);
            })
            ->where('no_asset', $row[2])
            ->first();

        if (!$asset) {
            return null;
        }

        $reportAsset = ReportAssets::where('asset_id', $asset->id)
            ->where('report_id', $report->id)
            ->first();

        if (!$reportAsset) {
            return null;
        }
        $reportAsset->status = $row[3];
        $reportAsset->save();

        // Mengembalikan DetailReport dengan data dari Excel
        return new DetailReport([
            'report_asset_id' => $reportAsset->id,
            'report_asset_id' => $reportAsset->id,
            'no_sr' => isset($row[4]) ? $row[4] : null,
            'no_wo' => isset($row[5]) ? $row[5] : null,
            'tanggal_identifikasi' => $row[6] ? $this->convertExcelDate($row[6]) : null,
            'status_sr' => isset($row[7]) ? $row[7] : null,
            'kondisi_asset' => isset($row[8]) ? $row[8] : null,
            'action_plan' => isset($row[9]) ? $row[9] : null,
            'progress_saat_ini' => isset($row[10]) ? $row[10] : null,
            'target_selesai' => isset($row[11]) ? $row[11] : null,
            'realisasi_selesai' => isset($row[12]) ? $row[12] : null,
            'issue' => isset($row[13]) ? $row[13] : null,
            'keterangan' => isset($row[14]) ? $row[14] : null,
        ]);
    }


    public function convertMonth($month, $data)
    {
        // Mapping bulan Indonesia ke bulan bahasa Inggris
        $bulanIndonesiaKeInggris = [
            'Januari' => 'January',
            'Februari' => 'February',
            'Maret' => 'March',
            'April' => 'April',
            'Mei' => 'May',
            'Juni' => 'June',
            'Juli' => 'July',
            'Agustus' => 'August',
            'September' => 'September',
            'Oktober' => 'October',
            'November' => 'November',
            'Desember' => 'December',
        ];

        $dateString = $month;

        // Ganti bulan dari bahasa Indonesia ke bahasa Inggris
        foreach ($bulanIndonesiaKeInggris as $bulanIndonesia => $bulanInggris) {
            $dateString = str_replace($bulanIndonesia, $bulanInggris, $dateString);
        }

        // Regular expression to match "Month YYYY" format (e.g., "January 2024")
        $regex = '/^(January|February|March|April|May|June|July|August|September|October|November|December) \d{4}$/';

        if (!preg_match($regex, $dateString)) {
            dd('Invalid month format: ', $data);
        }

        // Konversi string "October 2024" menjadi Carbon object
        $date = Carbon::createFromFormat('F Y', $dateString, 'Asia/Jakarta')->startOfMonth();


        // Tampilkan tanggal dalam format 'Y-m-d'
        return $date->format('Y-m-d');  // Output: 2024-10-01

    }

    private function convertExcelDate($excelDate)
    {
        // Jika nilai adalah angka
        if (is_numeric($excelDate)) {
            // Menghitung tanggal dengan Carbon
            return Carbon::createFromFormat('Y-m-d', '1899-12-30')->addDays($excelDate)->toDateString();
        }

        return null; // Kembalikan null jika bukan angka
    }
}
