<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetGroup;
use App\Models\DetailReport;
use App\Models\Location;
use App\Models\Report;
use App\Models\ReportAssets;
use App\Models\Unit;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Pest\Plugins\Retry;
use Carbon\Carbon;
use App\Exports\AssetsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;



class AssetHealthReportController extends Controller
{
    public function index()
    {


        $locations = Location::all();

        return view('pages.asset-health-report.index', compact('locations'));
    }

    public function deleteReport($id)
    {
        try {
            Report::where('id', $id)->delete();

            return back()->with('success', 'Report deleted successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong');
        }
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

    public function showReportUnit(Location $location, Report $report, Unit $unit, Request $request)
    {
       

        return view('pages.asset-health-report.showReportUnit', compact('location', 'report', 'unit'));
    }
    public function getAssetReport(Request $request)
    {
        // Ambil data report assets dengan relasi yang diperlukan
        $reportAsset = ReportAssets::with('asset', 'asset.assetGroup', 'report', 'unit', 'unit.location', 'detailReports')
            ->where('report_id', $request->report_id)
            ->where('unit_id', $request->unit_id);

        // Tambahkan pencarian jika parameter search ada
        if ($request->search) {
            $searchTerm = '%' . $request->search . '%';

            $reportAsset->where(function ($query) use ($searchTerm) {
                $query->where('status', 'like', $searchTerm) // Pencarian pada kolom 'status'
                    ->orWhereHas('asset', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('name', 'like', $searchTerm); // Pencarian pada nama asset
                    })
                    ->orWhereHas('asset.assetGroup', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('name', 'like', $searchTerm); // Pencarian pada grup asset
                    })
                    ->orWhereHas('unit', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('name', 'like', $searchTerm); // Pencarian pada nama unit
                    })
                    ->orWhereHas('unit.location', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('name', 'like', $searchTerm); // Pencarian pada lokasi unit
                    });
            });
        }

        // Paginasi dengan batas default 10
        $reportAsset = $reportAsset->paginate($request->limit ?? 10);

        // Return response JSON
        return response()->json($reportAsset);
    }

    public function exportExcel($locationId, $reportId, $unitId)
    {
        // Validasi dan ambil data terkait
        $location = Location::findOrFail($locationId);
        $unit = Unit::findOrFail($unitId);
        $report = Report::findOrFail($reportId);

        // Format nama file berdasarkan data yang ada
        $date = date('F Y', strtotime($report->date));
        $fileName = sprintf(
            'Assets Report-%s-%s-%s.xlsx',
            $date,
            $location->name,
            $unit->name
        );

        // Download file Excel dengan nama yang sesuai
        return Excel::download(
            new AssetsExport($report->id, $unit->id),
            $fileName
        );
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
            'location' => 'required|string|exists:locations,name',
        ]);
        try {

            // cek reportAsset jika sudah ada lokasi maka buatkan lokasi baru dan ambil data report asset dengan lokasi tertentu

            $location = Location::where('name', $validatedData['location'])->firstOrFail();

            // Ambil laporan terakhir berdasarkan lokasi
            $reportFirstLast = Report::with('reportAssets.detailReports')->where('location_id', $location->id)->orderBy('date', 'desc')->first();

            // Buat laporan baru (atau ambil jika sudah ada)
            $report = Report::firstOrCreate([
                'date' => $validatedData['date'] . '-01', // Tanggal untuk laporan baru
                'location_id' => $location->id,
            ]);

            if ($reportFirstLast == null) {
                $units = Unit::where('location_id', $location->id)->get();

                foreach ($units as $unit) {
                    $assets = Asset::where('unit_id', $unit->id)->where('is_active', '1')->get();

                    foreach ($assets as $asset) {
                        ReportAssets::updateOrCreate(
                            [
                                'report_id' => $report->id,
                                'unit_id' => $asset->unit_id,
                                'asset_id' => $asset->id,
                                'status' => $asset->status,
                            ],
                        );
                    }
                }
            } else {

                foreach ($reportFirstLast->reportAssets as $reportAsset) {
                    $newReportAsset = $report->reportAssets()->create([
                        'asset_id' => $reportAsset->asset_id,
                        'unit_id' => $reportAsset->unit_id,
                        'report_id' => $reportAsset->report_id,
                        'status' => $reportAsset->status,
                    ]);

                    foreach ($reportAsset->detailReports as $detailReport) {

                        $newReportAsset->detailReports()->create([
                            'no_sr' => $detailReport->no_sr,
                            'no_wo' => $detailReport->no_wo,
                            'tanggal_identifikasi' => $detailReport->tanggal_identifikasi,
                            'status_sr' => $detailReport->status_sr,
                            'kondisi_asset' => $detailReport->kondisi_asset,
                            'action_plan' => $detailReport->action_plan,
                            'progress_saat_ini' => $detailReport->progress_saat_ini,
                            'target_selesai' => $detailReport->target_selesai,
                            'realisasi_selesai' => $detailReport->realisasi_selesai,
                            'issue' => $detailReport->issue,
                            'keterangan' => $detailReport->keterangan,
                        ]);
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
                'keterangan' => $request->keterangan,
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
                'status' => $request->status,
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
                'keterangan' => $request->keterangan,
            ]);

            return back()->with('success', 'Detail report asset created successfully');
        } catch (\Throwable $th) {


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
    public function assetReport(Request $request)
    {


        $locations = Location::all();
        return view('pages.asset-report.index', compact('locations'));
    }

    public function searchAssetReport(Request $request)
    {
        $locations = Location::all();

        try {
            // Validasi input form
            $validated = $request->validate([
                'lokasi' => 'required',
                'status' => 'required',
            ]);

            // Query untuk mencari berdasarkan status dan lokasi
            $assertReport = DetailReport::with('reportAsset.asset.unit.location')
                ->whereHas('reportAsset', function ($query) use ($request) {
                    $query->where('status', $request->status);  // Filter berdasarkan status dari input
                })
                ->whereHas('reportAsset.asset.unit.location', function ($query) use ($request) {
                    $query->where('locations.name', $request->lokasi);  // Filter berdasarkan lokasi dari input
                })
                ->get();

            // Mengembalikan hasil ke view
            return view('pages.asset-report.index', compact('locations', 'assertReport'));
        } catch (\Throwable $th) {
            // Mengembalikan error jika terjadi kesalahan
            return back()->with('error', 'Something went wrong');
        }
    }
    public function showAssetReport($id_report_asset)
    {


        $detailReport = DetailReport::with('reportAsset.asset.assetGroup')
            ->where('report_asset_id', $id_report_asset)
            ->first();

        $detailReportsAll = DetailReport::where('report_asset_id', $id_report_asset)->get();

        return view('pages.asset-report.show', compact('detailReport', 'detailReportsAll'));
    }

    public function getDataStatus($id_report_asset)
    {
        // Mengambil status dari DetailReport beserta relasi reportAsset dan report
        $status = DetailReport::with('reportAsset.report')
            ->whereHas('reportAsset', function ($query) use ($id_report_asset) {
                // Menyaring berdasarkan id dari report_asset
                $query->where('report_asset_id', $id_report_asset);
            })
            ->whereHas('reportAsset.report', function ($query) {
                // Menyaring berdasarkan tahun ini
                $query->whereYear('date', Carbon::now()->year);
            })
            ->get();

        // Mengelompokkan data berdasarkan bulan dari Januari hingga Desember
        $monthlyStatus = collect(range(1, 12))->mapWithKeys(function ($month) use ($status) {
            // Memfilter data berdasarkan bulan
            $monthData = $status->filter(function ($item) use ($month) {
                return Carbon::parse($item->reportAsset->report->date)->month == $month;
            });

            // Menghitung status Normal, Abnormal, dan Fault
            $normalCount = $monthData->where('reportAsset.status', 'normal')->count();
            $abnormalCount = $monthData->where('reportAsset.status', 'abnormal')->count();
            $faultCount = $monthData->where('reportAsset.status', 'fault')->count();

            // Mengonversi angka bulan menjadi nama bulan
            $monthName = Carbon::create()->month($month)->format('F');

            return [
                $monthName => [
                    'normal_count' => $normalCount,
                    'abnormal_count' => $abnormalCount,
                    'fault_count' => $faultCount,
                ]
            ];
        });

        // Debug untuk melihat hasil
    }
}
