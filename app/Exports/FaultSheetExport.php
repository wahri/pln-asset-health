<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class FaultSheetExport implements FromCollection,WithTitle,WithHeadings, WithEvents
{
    protected $fault;

    public function __construct($fault)
    {
        $this->fault = $fault;
    }

    public function collection()
    {
        return collect($this->fault);
    }

    public function title(): string
    {
        return 'Detail fault';
    }
    public function headings(): array
    {
        return [
            'unit',
            'No Asset',
            'No SR',
            'No WO',
            'Tanggal Identifikasi',
            'Status Saat Ini',
            'Kondisi Saat Ini',
            'Kondisi Asset',
            'Action Plan',
            'Target Selesai',
            'Progres Saat Ini',
            'Realisasi Selesai',
            'Main Issue / Kendala',
            'keterangan',
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
                $event->sheet->getStyle('A1:N1')->applyFromArray($headerStyleGray);

                // Set row heights for better visibility
                $lastRow = count($this->fault) + 1; // Update this line to match your data source
                foreach (range(2, $lastRow) as $row) {
                    $event->sheet->getRowDimension($row)->setRowHeight(30);
                }

                // Set column widths to auto size for better fit
                foreach (range('A', 'N') as $columnID) {
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
                $event->sheet->getStyle("A1:N{$lastRow}")->applyFromArray($borderStyle);
            },
        ];
    }
}
