<?php

namespace App\Http\Controllers;

use App\Imports\AssetImport;
use App\Imports\ReportImport;
use Illuminate\Http\Request;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportDataController extends Controller
{
    public function importAssetByExcel(Request $request)
    {
        $request->validate([
            'fileAsset' => 'required|mimes:xlsx,xls,csv',
        ]);


        $import = new AssetImport;
        Excel::import($import, $request->file('fileAsset'));

        $messages = $import->getMessages();
        $no_assets = $import->getNoAsset();
        $nama_asset = $import->getAssetName();

        return back()->with('success', 'Asset imported successfully')
            ->with('messages', $messages);
    }


    public function importReportByExcel(Request $request)
    {
        try {
            $request->validate([
                'fileReport' => 'required|mimes:xlsx,xls,csv',
            ]);

            Excel::import(new ReportImport, $request->file('fileReport'));

            return back()->with('success', 'Report imported successfully');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('error', 'Something went wrong');
        }
    }
}
