<?php

namespace App\Exports;

use App\Models\Asset;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AssetsExport implements FromView, WithStyles
{
    protected $report;
    protected $unit;

    // Constructor untuk menerima parameter
    public function __construct($report, $unit)
    {
        $this->report = $report;
        $this->unit = $unit;
    }

    public function view(): View
    {
        $assets = Asset::with([
            'reportAssets' => function ($query) {
                $query->where('report_id', $this->report)
                    ->with('detailReports');
            },
            'assetGroup',
            'unit'
        ])
            ->where('unit_id', $this->unit)
            ->get();

        return view('exports.assets', compact('assets'));
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
                'horizontal' => 'center',
                'vertical' => 'center',
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
    }
}
