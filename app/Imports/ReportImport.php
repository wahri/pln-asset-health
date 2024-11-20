<?php

namespace App\Imports;

use App\Models\Asset;
use App\Models\DetailReport;
use App\Models\Location;
use App\Models\Report;
use App\Models\ReportAssets;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportImport implements ToModel, WithStartRow, WithHeadingRow
{
    protected $messages = [];

    public function getMessages(): array
    {
        return $this->messages;
    }
    public function startRow(): int
    {
        return 2; // assuming the first row is the header
    }
    public function model(array $row)
    {
        return DB::transaction(function () use ($row) {
            try {
                if (!isset($row['location']) || !isset($row['month_year']) || !isset($row['no_asset']) || !isset($row['status'])) {
                    return null;
                }

                if (trim($row['location']) == null || trim($row['month_year']) == null || trim($row['no_asset']) == null || trim($row['status']) == null) {
                    return null;
                }
                $location = Location::where('name', $row['location'])->first();
                if (!$location) {
                    return null;
                }

                $checkReportDate = Report::where('location_id', $location->id)
                    ->where('date', $this->convertMonth($row['month_year'], $row))
                    ->first();

                if (!$checkReportDate) {
                    $report = Report::firstOrCreate([
                        'location_id' => $location->id,
                        'date' => $this->convertMonth($row['month_year'], $row)
                    ]);

                    $units = Unit::where('location_id', $location->id)->get();

                    foreach ($units as $unit) {
                        $assets = Asset::where('unit_id', $unit->id)->where('is_active', '1')->get();

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

                $asset = Asset::where('no_asset', $row['no_asset'])->first();
                if (!$asset) {
                    return null;
                }
                $asset->status = $row['status'];
                $asset->save();

                
                $reportAsset = ReportAssets::where('asset_id', $asset->id)
                    ->where('report_id', $report->id)
                    ->first();

                if (!$reportAsset) {
                    return null;
                }
                $reportAsset->status = $row['status'];
                $reportAsset->save();

                $checkDetailReport = DetailReport::where('report_asset_id', $reportAsset->id)->first();
                if (!$checkDetailReport) {
                    $detailReport = DetailReport::create([
                        'report_asset_id' => $reportAsset->id,
                        'no_sr' => isset($row['no_sr']) ? $row['no_sr'] : null,
                        'no_wo' => isset($row['no_wo']) ? $row['no_wo'] : null,
                        'tanggal_identifikasi' => $row['tgl_identifikasi'] ? $this->convertExcelDate($row['tgl_identifikasi']) : null,
                        'status_sr' => isset($row['status_saat_ini']) ? $row['status_saat_ini'] : null,
                        'kondisi_asset' => isset($row['kondisi_asset']) ? $row['kondisi_asset'] : null,
                        'action_plan' => isset($row['action_plan']) ? $row['action_plan'] : null,
                        'progress_saat_ini' => isset($row['progress_saat_ini']) ? $row['progress_saat_ini'] : null,
                        'target_selesai' => isset($row['target_selesai']) ? $row['target_selesai'] : null,
                        'realisasi_selesai' => isset($row['realisasi_selesai']) ? $row['realisasi_selesai'] : null,
                        'issue' => isset($row['main_issue']) ? $row['main_issue'] : null,
                        'keterangan' => isset($row['keterangan']) ? $row['keterangan'] : null,
                    ]);
                    return $detailReport;
                }else{
                    $detailReport = $checkDetailReport;
                }


            } catch (\Exception $e) {
                $this->messages[] = "- Baris ke-" . $row['no'] . " error: " . $e->getMessage() . "<br>";
                return null;
            }
        });
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
