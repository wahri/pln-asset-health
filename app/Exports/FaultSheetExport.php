<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class FaultSheetExport implements FromCollection,WithTitle,WithHeadings
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
}
