<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class OverviewSheetExport implements FromCollection, WithTitle, WithHeadings, WithEvents
{
    protected $overview;

    public function __construct($overview)
    {
        $this->overview = $overview;
    }

    public function collection()
    {
        return collect($this->overview);
    }

    public function title(): string
    {
        return 'Overview';
    }

    public function headings(): array
    {
        return [
            'unit',
            'total',
            'normal(total)',
            'warning(total)',
            'fault(total)',
            'normal(%)',
            'warning(%)',
            'fault(%)',
            'asset(warning)',
            'asset(fault)',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Define styles for different sections
                $headerStyleGray = [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => Color::COLOR_WHITE],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF808080'], // abu abu background
                    ],
                ];

                $headerStylePurple = [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => Color::COLOR_WHITE],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF800080'], // ungu background
                    ],
                ];

                $headerStyleYellow = [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => Color::COLOR_BLACK],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFFFFF00'], // kuning background
                    ],
                ];

                $headerStyleRed = [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => Color::COLOR_WHITE],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFFF0000'], // merah background
                    ],
                ];

                $alignmentLeft = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ];

                // Apply styles to header rows
                $event->sheet->getStyle('A1:B1')->applyFromArray($headerStyleGray);
                $event->sheet->getStyle('C1')->applyFromArray($headerStylePurple);
                $event->sheet->getStyle('D1')->applyFromArray($headerStyleYellow);
                $event->sheet->getStyle('E1')->applyFromArray($headerStyleRed);
                $event->sheet->getStyle('F1')->applyFromArray($headerStylePurple);
                $event->sheet->getStyle('G1')->applyFromArray($headerStyleYellow);
                $event->sheet->getStyle('H1')->applyFromArray($headerStyleRed);
                $event->sheet->getStyle('I1')->applyFromArray($headerStyleRed);
                $event->sheet->getStyle('J1')->applyFromArray($headerStyleYellow);

                // Get last row for merging and styling purposes
                $lastRow = count($this->overview) + 1;

                // Apply left alignment to asset columns
                $event->sheet->getStyle("I2:I{$lastRow}")->applyFromArray($alignmentLeft);
                $event->sheet->getStyle("J2:J{$lastRow}")->applyFromArray($alignmentLeft);

                // Set row heights for better visibility
                foreach (range(2, $lastRow) as $row) {
                    $event->sheet->getRowDimension($row)->setRowHeight(30);
                }

                // Set column widths to auto size for better fit
                foreach (range('A', 'J') as $columnID) {
                    $event->sheet->getColumnDimension($columnID)->setAutoSize(true);
                }

                // Center-align header row
                $event->sheet->getStyle('A1:J1')->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Optional: Adjust column widths to provide extra padding/margin
                $event->sheet->getColumnDimension('I')->setWidth(40); // assetWarning
                $event->sheet->getColumnDimension('J')->setWidth(40); // assetFault

                // Add border around cells for better visual separation
                $borderStyle = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ];
                $event->sheet->getStyle("A1:J{$lastRow}")->applyFromArray($borderStyle);
            },
        ];
    }


}
