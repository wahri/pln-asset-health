<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class AssetHealthReportController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        return view('pages.asset-health-report.index', compact('locations'));
    }

    public function locationDetail(Location $location)
    {
        return view('pages.asset-health-report.location-detail', compact('location'));
    }
}
