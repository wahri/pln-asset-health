<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\DetailReport;
use App\Models\Location;
use App\Models\Report;
use App\Models\ReportAssets;
use App\Models\Unit;
use Illuminate\Http\Request;

class AssetHealthReportController extends Controller
{
  public function index()
  {
    $locations = Location::all();
    return view('pages.asset-health-report.index', compact('locations'));
  }

  public function show($locationName)
  {
    // Ambil lokasi berdasarkan nama
    $location = Location::where('name', $locationName)->firstOrFail();

    // Ambil semua report assets berdasarkan lokasi melalui relasi unit dan asset
    $reportAssets = ReportAssets::whereHas('asset.unit.location', function ($query) use ($location) {
      // Filter untuk hanya mengambil report assets dari lokasi yang sesuai
      $query->where('id', $location->id);
    })->with('asset.unit.location') // Eager load relasi asset, unit, dan location
      ->get();

    $reports = Report::where('location_id', $location->id)->get();


    // Kirim data ke view dengan location dan reportAssets
    return view('pages.asset-health-report.show', compact('location', 'reportAssets', 'locationName', 'reports'));
  }

  public function showReport(Location $location, Report $report)
  {
    $units = Unit::where('location_id', $location->id)->get();
    return view('pages.asset-health-report.showReport', compact('location', 'report', 'units'));
  }
  public function showReportUnit(Location $location, Report $report, Unit $unit)
  {
    $reportAssets = ReportAssets::whereHas('asset', function ($query) use ($unit) {
      $query->where('unit_id', $unit->id);
    })->where('report_id', $report->id)
      ->with(['asset', 'asset.assetGroup'])
      ->get()
      ->groupBy('asset.assetGroup.name');

    return view('pages.asset-health-report.showReportUnit', compact('location', 'report', 'unit', 'reportAssets'));
  }

  public function editReportAsset(ReportAssets $reportAsset)
  {
    $reportAsset->load('asset');
    return view('pages.asset-health-report.edit', compact('reportAsset'));
  }


  public function addReportDate(Request $request)
  {
    $validatedData = $request->validate([
      'date' => 'required|date',
      'location' => 'required|string|exists:locations,name'
    ]);

    try {
      $location = Location::where('name', $validatedData['location'])->firstOrFail();

      $report = Report::firstOrCreate([
        'date' => $validatedData['date'],
        'location_id' => $location->id
      ]);


      $units = Unit::where('location_id', $location->id)->get();

      foreach ($units as $unit) {
        $assets = Asset::where('unit_id', $unit->id)->get();


        foreach ($assets as $asset) {
          ReportAssets::updateOrCreate(
            [
              'report_id' => $report->id,
              'asset_id' => $asset->id,
              'status' => $asset->status
            ],
          );
        }
      }


      return back()->with('success', 'Report date and assets added successfully.');
    } catch (\Throwable $th) {
      return back()->with('error', 'An error occurred: ' . $th->getMessage());
    }
  }

  public function detail($id_report_asset)
  {

    $reportDetail = DetailReport::firstOrCreate([
      'report_asset_id' => $id_report_asset,

    ]);

    $detailReports = DetailReport::where('id', $reportDetail->id)->first();
    return view('pages.asset-health-report.detail', compact('detailReports'));
  }

  public function UpdatedetailReports(Request $request, $id)
  {
    try {
      DetailReport::where('id', $id)->update([
        'no_sr' => $request->no_sr,
        'no_wo' => $request->no_wo,
        'status' => $request->status,
        'issue' => $request->issue,
        'information' => $request->information,
        'proses' => $request->proses,
        'keterangan' => $request->keterangan,
        'deskripsi_asset' => $request->deskripsi_asset,
        'kondisi_asset' => $request->kondisi_asset,
        'target_selesai' => $request->target_selesai,
        'persentase_progress' => $request->persentase_progress,
        'realisasi_selesai' => $request->realisasi_selesai,
        'tanggal_identifikasi' => $request->tanggal_identifikasi
      ]);

      return back();
    } catch (\Throwable $th) {
      return back();
    }
  }
}
