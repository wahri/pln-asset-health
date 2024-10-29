<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class WarningSheetExport implements FromCollection,WithTitle,WithHeadings
{
    protected $warning;

    public function __construct($warning)
    {
        $this->warning = $warning;
    }

    public function collection()
    {
        return collect($this->warning);
    }

    public function title(): string
    {
        return 'Detail Warning';
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
}
