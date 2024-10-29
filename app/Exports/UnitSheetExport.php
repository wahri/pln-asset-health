<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class UnitSheetExport implements FromCollection,WithTitle,WithHeadings
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
        return 'Unit Data';
    }
    public function headings(): array
    {
        return [
            'Unit',
            'System',
            'No Asset',
            'Equipment',
            'Status',
            
        ];
    }
}
