<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\System;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    protected $system;

    protected $asset;

    public function __construct(System $system, Asset $asset)
    {
        $this->system = $system;
        $this->asset = $asset;
    }

    public function index()
    {
        $system = $this->system->getAllData();
        $asset = $this->asset->getAllData();

        return view('pages.asset.index', compact('system', 'asset'));
    }

    public function store(Request $request)
    {
        try {
            $this->asset->createData([
                'no_asset' => $request->noAsset,
                'system_id' => $request->systemName,
                'name' => $request->nameAsset,

            ]);

            return redirect()->back()->with('success', 'Data created successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->asset->updateData([
                'no_asset' => $request->noAsset,
                'system_id' => $request->systemName,
                'name' => $request->nameAsset,
            ], $id);

            return redirect()->back()->with('success', 'Data updated successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function destroy($id)
    {
        try {
            $this->asset->deleteData($id);

            return redirect()->back()->with('success', 'Data deleted successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}
