<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailReport extends Model
{
    use HasFactory;

    protected $table = 'detail_report';

    protected $fillable = [
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
    ];


    public function reportAsset()
    {
        return $this->belongsTo(ReportAssets::class);
    }
}
