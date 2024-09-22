<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $location;

    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    public function index()
    {
       
        $location = $this->location->getAllData();

        return view('pages.asset-management.location.index', compact('location'));
    }

    public function store(Request $request)
    {
        try {
            $this->location->createData([
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
            $this->location->updateData([
                'name' => $request->locationUnit,
            ], $id);

            return back()->with('success', 'Location updated successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function destroy($id)
    {

        try {
            $this->location->deleteData($id);

            return back()->with('success', 'Location deleted successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong');
        }
    }
}
