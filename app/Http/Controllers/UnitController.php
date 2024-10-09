<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index($name)
    {


        $location = Location::firstOrCreate(['name' => $name]);

        // $unit = $this->unit->getDataALLWhere('location_id', $location->id);
        $unit = Unit::where('location_id', $location->id)->get();

        // Dapatkan semua data lokasi
        $locations = Location::all();

        // Kembalikan view dengan data unit dan lokasi
        return view('pages.asset-management.unit.index', compact('unit', 'locations', 'location'));
    }

    public function store(Request $request)
    {

        try {

            Unit::create([
                'name' => $request->nameUnit,
                'location_id' => $request->location,
            ]);

            return back()->with('success', 'Unit created successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function update(Request $request, $id)
    {
        try {

            Unit::where('id', $id)->update([
                'name' => $request->nameUnit,
                'location_id' => $request->location,
            ]);

            return back()->with('success', 'Unit updated successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function destroy($id)
    {
        try {

            Unit::find($id)->delete();

            return back()->with('success', 'Unit deleted successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong');
        }
    }
}
