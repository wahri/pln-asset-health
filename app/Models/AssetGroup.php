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

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function createData($data)
    {
        return $this->create($data);
    }

    public function updateData($data, $id)
    {
        return $this->where('id', $id)->update($data);
    }

    public function deleteData($id)
    {
        return $this->where('id', $id)->delete();
    }

    public function getData($id)
    {
        return $this->where('id', $id)->first();
    }

    public function getAllData()
    {
        return $this->get();
    }
}
