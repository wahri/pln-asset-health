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
        'status',
        'issue',
        'information',
        'proses',
        'keterangan',
        'deskripsi_asset',
        'kondisi_asset',
        'target_selesai',
        'persentase_progress',
        'realisasi_selesai',
        'tanggal_identifikasi',
    ];

    public function reportAsset()
    {
        return $this->belongsTo(ReportAssets::class);
    }
}
