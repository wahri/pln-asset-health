<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        return view('pages.unit.index');
    }
    public function store(Request $request)
    {
        dd('store');
    }
    public function update(Request $request, $id)
    {
        dd('update');
    }
    public function destroy($id)
    {
        dd('destroy');
    }
}
