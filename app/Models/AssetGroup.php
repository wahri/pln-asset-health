<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'name',
    ];

    public function assets()
    {
        return $this->hasMany(Asset::class, 'asset_group_id', 'id');
    }
}
