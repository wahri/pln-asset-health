<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {

        $location = Location::all();

        return view('pages.asset-management.location.index', compact('location'));
    }

    public function store(Request $request)
    {
        try {

            Location::create([
                'name' => $request->locationUnit,
            ]);

            return back()->with('success', 'Location created successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function update(Request $request, $id)
    {

        try {

            Location::where('id', $id)->update([
                'name' => $request->locationUnit,
            ]);

            return back()->with('success', 'Location updated successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function destroy($id)
    {

        try {

            Location::find($id)->delete();

            return back()->with('success', 'Location deleted successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong');
        }
    }
}
