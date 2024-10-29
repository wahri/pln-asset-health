<?php

namespace App\Exports;

use App\Models\DetailReport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class DetailReportSheetExport implements FromCollection,WithHeadings,WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DetailReport::all();
    }
    public function title(): string
    {
        return 'detailReport';
    }
    public function headings(): array
    {
        return [
            'report_asset_id',
            'no_sr',
            'no_wo',
            'tanggal_identifikasi',
            'status_sr',
            'kondisi_asset',
            'action_plan',
            'progress_saat_ini',
            'target_selesai',
            'realisasi_selesai',
            'issue',
            'keterangan',
        ];
    }
}
