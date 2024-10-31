<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class UnitSheetExport implements FromCollection,WithTitle,WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $unit;

    public function __construct($unit)
    {
        $this->unit = $unit;
    }
    public function collection()
    {
        return collect($this->unit);
    }

    public function title(): string
    {
        return 'Unit';
    }
    public function headings(): array
    {
        return [
            'Unit',
            'System',
            'No Asset',
            'Equipment',
            // 'Status',
            
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Define a unified header style
                $headerStyleGray = [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => Color::COLOR_WHITE],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF808080'], // gray background
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ];

                // Apply styles to header row
                $event->sheet->getStyle('A1:D1')->applyFromArray($headerStyleGray);

                // Set row heights for better visibility
                $lastRow = count($this->unit) + 1; // Update this line to match your data source
                foreach (range(2, $lastRow) as $row) {
                    $event->sheet->getRowDimension($row)->setRowHeight(30);
                }

                // Set column widths to auto size for better fit
                foreach (range('A', 'D') as $columnID) {
                    $event->sheet->getColumnDimension($columnID)->setAutoSize(true);
                }

                // Set margins for the sheet
                $margins = $event->sheet->getPageMargins();
                $margins->setTop(0.5);    // Set top margin
                $margins->setBottom(0.5); // Set bottom margin
                $margins->setLeft(0.5);   // Set left margin
                $margins->setRight(0.5);  // Set right margin

                // Add border around cells for better visual separation
                $borderStyle = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ];
                $event->sheet->getStyle("A1:D{$lastRow}")->applyFromArray($borderStyle);
            },
        ];
    }
}
