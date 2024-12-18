<?php

namespace App\Exports;

use App\Models\Asset;
use App\Models\ReportAssets;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;


class AssetsReportExport implements FromView, WithStyles
{
  
    public function view(): View
    {

        $latestReports = DB::table('reports as r1')
        ->join('locations as l', 'r1.location_id', '=', 'l.id')
        ->select('r1.location_id', 'r1.id as report_id', 'l.name as location_name', DB::raw('MONTH(r1.date) as report_month'))
        ->whereRaw('r1.date = (SELECT MAX(r2.date) FROM reports as r2 WHERE r2.location_id = r1.location_id)')
        ->get();


        $reportAsset = ReportAssets::with('asset', 'asset.assetGroup', 'report', 'unit', 'unit.location', 'detailReports')
        ->whereIn('report_id', $latestReports->pluck('report_id'))
        ->where('status', '!=', 'normal')
        ->get();



        return view('exports.assets', compact('reportAsset'));
    }

    /**
     * Atur gaya untuk sel Excel.
     */
    public function styles(Worksheet $sheet)
    {
        // Mengatur gaya untuk semua kolom yang memiliki data
        $highestRow = $sheet->getHighestRow(); // Baris terakhir dengan data
        $highestColumn = $sheet->getHighestColumn(); // Kolom terakhir dengan data
        $range = 'A1:' . $highestColumn . $highestRow;

        // Terapkan gaya untuk seluruh rentang sel
        $sheet->getStyle($range)->applyFromArray([
            'alignment' => [
                'horizontal' => 'left',
                'vertical' => 'top',
            ],
        ]);

        // Tambahkan gaya khusus untuk header
        $sheet->getStyle('A1:' . $highestColumn . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFFE0'], // Warna latar header
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        // Auto size untuk semua kolom
        foreach (range('A', $highestColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }

}
