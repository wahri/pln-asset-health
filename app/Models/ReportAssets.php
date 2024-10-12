<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportAssets extends Model
{
    use HasFactory;
    protected $fillable = ['asset_id', 'report_id', 'status'];


    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function detailReports()
    {
        return $this->hasMany(DetailReport::class, 'report_asset_id');
    }


    // Aksesori untuk mendapatkan kelas CSS berdasarkan status
    public function getStatusClassAttribute()
    {
        switch ($this->status) {
            case 'normal':
                return 'success'; // warna hijau (success)
            case 'abnormal':
                return 'warning'; // warna kuning (warning)
            case 'fault':
                return 'danger'; // warna merah (danger)
            default:
                return 'secondary'; // default warna jika status lain
        }
    }
}
