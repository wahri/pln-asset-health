<?php

namespace App\Exports;

use App\Models\Asset;
use App\Models\ReportAssets;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AssetsExport implements FromView, WithStyles
{
    protected $report;

    // Constructor untuk menerima parameter
    public function __construct($report)
    {
        $this->report = $report;
    }

    public function view(): View
    {



        // Ambil data report assets dengan relasi yang diperlukan
        $reportAsset = ReportAssets::with('asset', 'asset.assetGroup', 'report', 'unit', 'unit.location', 'detailReports')
            ->where('report_id', $this->report);
        // Tambahkan pencarian jika parameter search ada

        // Paginasi dengan batas default 10
        $reportAsset = $reportAsset->get();
        // Return response JSON




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
