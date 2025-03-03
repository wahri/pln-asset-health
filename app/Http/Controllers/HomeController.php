<?php

namespace App\Http\Controllers;

use App\Exports\AssetsReportExport;
use App\Models\DetailReport;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\ReportAssets;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\Report;

class HomeController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        $years  = Report::select(DB::raw('YEAR(date) as year'))->distinct()->get();

        return view('pages.index', compact('locations', 'years'));
    }

    public function detailAssets($report_assets_id)
    {


        $reportAsset = ReportAssets::findOrFail($report_assets_id);


        $locationName = $reportAsset->asset->unit->location->name;
        $month = date('F Y', strtotime($reportAsset->report->date));
        $unit = $reportAsset->asset->unit->name;

        $statusSR = [
            'APPR',
            'CAN',
            'CLOSE',
            'COMP',
            'HISTEDIT',
            'INPLAN',
            'INPLN',
            'INPRG',
            'PTWR',
            'WAPPR',
            'WAPPR',
            'WENG',
            'WEQSHUT',
            'WJOBCARD',
            'WMATL',
            'WMATSHUT',
            'WOUTAGE',
            'WPCOND',
            'WPREP',
            'WPTWR',
        ];

        $detailReportsAll = DetailReport::where('report_asset_id', $report_assets_id)->get();



        return view('pages.detail-assets', compact('locationName', 'month', 'unit', 'statusSR', 'detailReportsAll', 'reportAsset'));
    }

    public function exportExcelAssets()
    {
        $fileName = 'Asset_Wellness_Monitoring_System.xlsx'; // Menambahkan ekstensi .xlsx

        // Download file Excel dengan nama yang sesuai
        return Excel::download(
            new AssetsReportExport(),
            $fileName
        );
    }
}
