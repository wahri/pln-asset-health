<?php

namespace App\Http\Controllers;

use App\Models\System;
use App\Models\Unit;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    protected $system;

    protected $unit;

    public function __construct(System $system, Unit $unit)
    {
        $this->system = $system;
        $this->unit = $unit;
    }

    public function index()
    {
        $unit = $this->unit->getAllData();
        $system = $this->system->getAllData();

        return view('pages.system.index', compact('unit', 'system'));
    }

    public function store(Request $request)
    {
        try {
            $this->system->createData([
                'unit_id' => $request->unitName,
                'name' => $request->nameSystem,
            ]);

            return redirect()->back()->with('success', 'Data has been created successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->system->updateData([
                'unit_id' => $request->unitName,
                'name' => $request->nameSystem,
            ], $id);

            return redirect()->back()->with('success', 'Data has been updated successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function destroy($id)
    {
        try {
            $this->system->deleteData($id);

            return redirect()->back()->with('success', 'Data has been deleted successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}
