<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetGroup;
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

    $reports = Report::where('location_id', $location->id)
      ->orderBy('date', 'desc') // Mengurutkan berdasarkan kolom created_at secara menurun
      ->get();


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

    $assetsGrup = AssetGroup::all();

    return view('pages.asset-health-report.showReportUnit', compact('location', 'report', 'unit', 'reportAssets', 'assetsGrup'));
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

      // cek reportAsset jika sudah ada lokasi maka buatkan lokasi baru dan ambil data report asset dengan lokasi tertentu



      $location = Location::where('name', $validatedData['location'])->firstOrFail();



      // Ambil laporan terakhir berdasarkan lokasi
      $reportFirstLast = Report::where('location_id', $location->id)->orderBy('date', 'desc')->first();




      // Buat laporan baru (atau ambil jika sudah ada)
      $report = Report::firstOrCreate([
        'date' => $validatedData['date'] . '-01', // Tanggal untuk laporan baru
        'location_id' => $location->id
      ]);

      if ($reportFirstLast == null) {
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
      } else {
        $units = Unit::where('location_id', $location->id)->get();

        foreach ($units as $unit) {
          $assets = Asset::where('unit_id', $unit->id)->get();

          foreach ($assets as $asset) {
            // Ambil status dari reportAssets yang terkait dengan report terakhir
            $previousReportAssets = ReportAssets::where('report_id', $reportFirstLast->id)
              ->where('asset_id', $asset->id)
              ->first();

            // Jika ada record pada report sebelumnya, copy statusnya ke report baru
            if ($previousReportAssets) {
              ReportAssets::updateOrCreate(
                [
                  'report_id' => $report->id,  // Menghubungkan dengan laporan baru
                  'asset_id' => $asset->id     // Hubungkan dengan asset yang sama
                ],
                [
                  'status' => $previousReportAssets->status // Copy status dari laporan sebelumnya
                ]
              );
            }
          }
        }
      }








      return back()->with('success', 'Report date and assets added successfully.');
    } catch (\Throwable $th) {
      return back()->with('error', 'An error occurred: ' . $th->getMessage());
    }
  }

  public function detail($id_report_asset)
  {




    $reportAsset = ReportAssets::findOrFail($id_report_asset);






    $locationName = $reportAsset->asset->unit->location->name;
    $month = date('F Y', strtotime($reportAsset->report->date));
    $unit = $reportAsset->asset->unit->name;

    $statusSR = [
      "0",
      "-",
      "APPR",
      "INPROG",
      "INPROGINPROG",
      "MENUNGGU WO FEEDBACK",
      "WAMTL",
      "WFEEDBACK",
      "WJOBCARD",
      "WMATL",
      "WOUTAGE",
      "WPROC",
      "WUNSHUT"
    ];

    $detailReportsAll = DetailReport::where('report_asset_id', $id_report_asset)->get();



    return view('pages.asset-health-report.detail', compact('locationName', 'month', 'unit', 'statusSR', 'detailReportsAll', 'reportAsset'));
  }

  public function UpdatedetailReports(Request $request, $id)
  {


    try {
      DetailReport::where('id', $id)->update([
        'no_sr' => $request->no_sr,
        'no_wo' => $request->no_wo,
        'tanggal_identifikasi' => $request->tanggal_identifikasi,
        'status_sr' => $request->status_sr,
        'kondisi_asset' => $request->kondisiAsset,
        'action_plan' => $request->actionPlan,
        'progress_saat_ini' => $request->progresSaatIni,
        'target_selesai' => $request->targetSelesai,
        'realisasi_selesai' => $request->realisasiSelesai,
        'issue' => $request->issue,
        'keterangan' => $request->keterangan
      ]);






      return back()->with(
        'success',
        'Detail report asset updated successfully'
      );
    } catch (\Throwable $th) {

      return back()->with(
        'error',
        'Something went wrong'
      );
    }
  }
  public function updateReportAssets(Request $request, $id_report_asset)
  {

    try {
      ReportAssets::where('id', $id_report_asset)->update([
        'status' => $request->status
      ]);
      return back()->with('success', 'Report asset updated successfully');
    } catch (\Throwable $th) {
      return back()->with('error', 'Something went wrong');
    }
  }

  public function deleteDetailReportAsset($id_detail_report)
  {
    try {
      DetailReport::where('id', $id_detail_report)->delete();
      return back()->with('success', 'Detail report asset deleted successfully');
    } catch (\Throwable $th) {
      return back()->with('error', 'Something went wrong');
    }
  }

  public function StoreDetailReports(Request $request, $id_report_asset)
  {

    try {
      // $request->validate([
      //   'no_sr' => 'required|string',
      //   'no_wo' => 'required|string',
      //   'tanggal_identifikasi' => 'required|date',
      //   'status_sr' => 'required|string',
      //   'kondisiAsset' => 'required|string',
      //   'actionPlan' => 'required|string',
      //   'progresSaatIni' => 'required|string',
      //   'targetSelesai' => 'required|string',
      //   'realisasiSelesai' => 'required|string',
      // ]);


      DetailReport::create([
        'report_asset_id' => $id_report_asset,
        'no_sr' => $request->no_sr,
        'no_wo' => $request->no_wo,
        'tanggal_identifikasi' => $request->tanggal_identifikasi,
        'status_sr' => $request->status_sr,
        'kondisi_asset' => $request->kondisiAsset,
        'action_plan' => $request->actionPlan,
        'progress_saat_ini' => $request->progresSaatIni,
        'target_selesai' => $request->targetSelesai,
        'realisasi_selesai' => $request->realisasiSelesai,
        'issue' => $request->issue,
        'keterangan' => $request->keterangan
      ]);

      return back()->with('success', 'Detail report asset created successfully');
    } catch (\Throwable $th) {

      dd($th->getMessage());

      return back()->with('error', 'Something went wrong');
    }
  }

  public function changeStatus(Request $request)
  {

    try {

      ReportAssets::where('id', $request->id)->update(['status' => $request->status]);
      return response()->json(['message' => 'Status changed successfully'], 200);
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }
}
