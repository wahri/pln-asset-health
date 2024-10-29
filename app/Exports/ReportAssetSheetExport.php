<?php

namespace App\Exports;

use App\Models\ReportAssets;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReportAssetSheetExport implements FromCollection,WithTitle,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ReportAssets::all();
    }

    public function title(): string
    {
        return 'reportAsset';
    }
    public function headings(): array
    {
        return [
            'asset_id',
            'report_id',
            'status'
        ];
    }
}
