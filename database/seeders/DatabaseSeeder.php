<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\AssetGroup;
use App\Models\Location;
use App\Models\Unit;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('password'),
        ]);

        // $location = Location::create([
        //     'name' => 'Duri',
        // ]);

        // Unit::insert([
        //     [
        //         'location_id' => $location->id,
        //         'name' => 'PLTMG 1',
        //     ],
        //     [
        //         'location_id' => $location->id,
        //         'name' => 'PLTMG 2',
        //     ],
        //     [
        //         'location_id' => $location->id,
        //         'name' => 'PLTMG 3',
        //     ],
        // ]);

        // AssetGroup::insert([
        //     [
        //         'unit_id' => 1,
        //         'name' => 'SWITCHGEAR 15 KV',
        //     ],
        //     [
        //         'unit_id' => 1,
        //         'name' => 'GENERATOR FRAME, INCL. STATOR, ROTOR',
        //     ],
        // ]);

        // Asset::insert([
        //     [
        //         'unit_id' => 1,
        //         'asset_group_id' => 1,
        //         'no_asset' => 'PLBP-MG-01-AKA10GS001',
        //         'name' => 'SWITCHGEAR 15 KV',
        //     ],
        //     [
        //         'unit_id' => 1,
        //         'asset_group_id' => 2,
        //         'no_asset' => 'PLBP-MG-01-MKA10AG001',
        //         'name' => 'ROTOR ASSY GENERATOR',
        //     ],
        //     [
        //         'unit_id' => 1,
        //         'asset_group_id' => 2,
        //         'no_asset' => 'PLBP-MG-01-MKA10AG002',
        //         'name' => 'STATOR ASSY GENERATOR',
        //     ],
        // ]);
    }
}
