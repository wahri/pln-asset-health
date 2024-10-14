<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'asset_group_id',
        'no_asset',
        'name',
        'status',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function assetGroup()
    {
        return $this->belongsTo(AssetGroup::class, 'asset_group_id', 'id');
    }

    public function reportAssets()
    {
        return $this->hasMany(ReportAssets::class);
    }

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
