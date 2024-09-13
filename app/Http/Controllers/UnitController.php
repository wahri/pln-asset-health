<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    protected $unit;
    protected $location;
    public function __construct(Unit $unit, Location $location)
    {
        $this->unit = $unit;
        $this->location = $location;
    }
    public function index()
    {
        $unit = $this->unit->getAllData();
        $location = $this->location->getAllData();
        return view('pages.unit.index', compact('unit', 'location'));
    }
    public function store(Request $request)
    {
      try {
        $this->unit->createData([
            'name' => $request->nameUnit,
          'location_id' => $request->location
        ]);
        return back()->with('success', 'Unit created successfully');
      } catch (\Throwable $th) {
        return back()->with('error', 'Something went wrong');
      }
    }
    public function update(Request $request, $id)
    {
       try {
         $this->unit->updateData([
           'name' => $request->nameUnit,
           'location_id' => $request->location
         ], $id);
         return back()->with('success', 'Unit updated successfully');
       } catch (\Throwable $th) {
        return back()->with('error', 'Something went wrong');
       }
    }
    public function destroy($id)
    {
       try {
         $this->unit->deleteData($id);
         return back()->with('success', 'Unit deleted successfully');
       } catch (\Throwable $th) {
       return back()->with('error', 'Something went wrong');
       }
    }
}
