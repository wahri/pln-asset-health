<?php

namespace App\Imports;

use App\Models\Asset;
use App\Models\AssetGroup;
use App\Models\Location;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToModel;

class AssetImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Memastikan tidak menangkap baris kosong atau header dengan mengecek apakah 'location' adalah header
        if ($row[0] === 'location' || $row[1] === 'unit' || $row[2] === 'no_asset' || $row[3] === 'asset_group' || $row[4] === 'asset_name') {
            return null;
        }

        $checkAsset = Asset::where('no_asset', $row[2])->first();
        if ($checkAsset) {
            return null;
        }

        // Mencari atau membuat lokasi berdasarkan kolom 'location'
        $location = Location::firstOrCreate(['name' => $row[0]]);

        // Mencari atau membuat unit berdasarkan kolom 'unit' dan 'location_id'
        $unit = Unit::firstOrCreate(
            [
                'location_id' => $location->id,
                'name' => $row[1]
            ]
        );

        // Mencari atau membuat asset group berdasarkan kolom 'asset_group' dan 'unit_id'
        $assetGroup = AssetGroup::firstOrCreate(
            [
                'unit_id' => $unit->id,
                'name' => $row[3]
            ]
        );

        // Membuat asset baru dengan data yang diambil dari Excel
        return new Asset([
            'unit_id' => $unit->id,
            'asset_group_id' => $assetGroup->id,
            'no_asset' => $row[2],  // Kolom 'no_asset'
            'name' => $row[4],      // Kolom 'asset_name'
            'status' => 'normal',   // Set nilai default untuk status
        ]);
    }
}
