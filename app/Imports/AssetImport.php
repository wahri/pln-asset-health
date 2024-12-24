<?php

namespace App\Imports;

use App\Models\Asset;
use App\Models\AssetGroup;
use App\Models\Location;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class AssetImport implements ToModel, WithStartRow, WithHeadingRow
{
    protected $messages = [];
    protected $assets = [];


    public function getMessages(): array
    {
        return $this->messages;
    }

    public function getAssets(): array
    {
        return $this->assets;
    }

    public function startRow(): int
    {
        return 2; // assuming the first row is the header
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return DB::transaction(function () use ($row) {
            try {
                if (!isset($row['no']) || !isset($row['location']) || !isset($row['unit']) || !isset($row['asset_name'])) {
                    return null;
                }
                if (trim($row['no']) == null || trim($row['location']) == null || trim($row['unit']) == null || trim($row['asset_name']) == null) {
                    return null;
                }


                // Mencari atau membuat lokasi berdasarkan kolom 'location'
                $location = Location::firstOrCreate(['name' => trim($row['location'])]);

                // Mencari atau membuat unit berdasarkan kolom 'unit' dan 'location_id'
                $unit = Unit::firstOrCreate(
                    [
                        'location_id' => $location->id,
                        'name' => trim($row['unit'])
                    ]
                );

                // Mencari atau membuat asset group berdasarkan kolom 'asset_group' dan 'unit_id'
                $assetGroup = null;
                if (isset($row['asset_group'])) {
                    $assetGroup = AssetGroup::firstOrCreate(
                        [
                            'unit_id' => $unit->id,
                            'name' => trim($row['asset_group'])
                        ]
                    );
                }

                $asset = Asset::where('name', trim($row['asset_name']));

                if (isset($row['no_asset'])) {
                    $asset->where('no_asset', trim($row['no_asset']));
                } else if ($assetGroup != null) {
                    $asset->where('asset_group_id', $assetGroup->id);
                }
                $asset = $asset->first();

                if ($asset) {
                    $this->assets[] = $asset->id;
                    if (isset($row['no_asset'])) {
                        $asset->no_asset = trim($row['no_asset']);
                    }
                    if ($assetGroup != null) {
                        $asset->asset_group_id = $assetGroup->id;
                    }
                    $asset->save();
                } else {
                    $asset = Asset::create([
                        'unit_id' => $unit->id,
                        'no_asset' => trim($row['no_asset']),
                        'name' => trim($row['asset_name']),
                        'mpi' => $row['mpi'] ?? null,
                        'asset_group_id' => $assetGroup->id ?? null
                    ]);
                    $this->assets[] = $asset->id;
                }
                return $asset;
            } catch (\Exception $e) {
                $this->messages[] = "- Baris ke-" . $row['no'] . " error: " . $e->getMessage() . "<br>";
                return null;
            }
        });
    }
}
