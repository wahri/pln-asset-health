<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetGroup;
use App\Models\Unit;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index($name_unit)
    {


        $unit = Unit::firstOrCreate(['name' => $name_unit]);

        $dataAssetGroup = AssetGroup::with('assets')->where('unit_id', $unit->id)->get();

        $assetGroup = AssetGroup::all();

        return view('pages.asset-management.asset.index', compact('dataAssetGroup', 'assetGroup', 'unit'));
    }

    public function store(Request $request)
    {

       

        try {

            $request->validate([
                'unit_id' => 'required',
                'assetGroup' => 'required',
                'noAsset' => 'required',
                'nameAsset' => 'required',
                'status' => 'required',
            ]);

            $assetGroup = AssetGroup::firstOrCreate([
                'unit_id' => $request->unit_id,
                'name' => $request->assetGroup]
            );

            asset::create([
                'unit_id' => $request->unit_id,
                'asset_group_id' => $assetGroup->id,
                'no_asset' => $request->noAsset,
                'name' => $request->nameAsset,
                'status' => $request->status,

            ]);

            return redirect()->back()->with('success', 'Data created successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function update(Request $request, $id)
    {

        try {

            $assetGroup = AssetGroup::firstOrCreate(
                [
                    'unit_id' => $request->unit_id,
                    'name' => $request->assetGroup,
                ]
            );

            Asset::where('id', $id)->update([
                'no_asset' => $request->noAsset,
                'asset_group_id' => $assetGroup->id,
                'name' => $request->nameAsset,
                'status' => $request->status,
            ]);

            return redirect()->back()->with('success', 'Data updated successfully!');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function destroy($id)
    {

        try {
            Asset::destroy($id);

            return redirect()->back()->with('success', 'Data deleted successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}
