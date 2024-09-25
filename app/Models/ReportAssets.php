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
}
