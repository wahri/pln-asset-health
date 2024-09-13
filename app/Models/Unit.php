<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;


    protected $table = 'unit';

    protected $fillable = [
        'location_id',
        'name',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
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
