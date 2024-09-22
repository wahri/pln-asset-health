<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssetHealthReportController extends Controller
{
    public function index()
    {
        return view('pages.asset-health-report.index');
    }
}
