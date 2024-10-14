<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'location_id',
    ];

    public function reportAssets()
    {
        return $this->hasMany(ReportAssets::class);
    }
}
