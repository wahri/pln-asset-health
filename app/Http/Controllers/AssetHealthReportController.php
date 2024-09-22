<?php

namespace App\Http\Controllers;

class AssetHealthReportController extends Controller
{
    public function index()
    {
        return view('pages.asset-health-report.index');
    }
}
