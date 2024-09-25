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
}
