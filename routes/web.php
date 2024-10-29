<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetHealthReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportDataController;
use App\Http\Controllers\ImportDataController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::prefix('/dashboard')->name('dashboard.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::post('/getDataChart', [DashboardController::class, 'getDataChart'])->name('getDataChart');
});

Route::middleware(['auth'])->group(function () {

    Route::prefix('/asset-health-report')->name('assetHealthReport.')->group(function () {
        // Menampilkan daftar report asset health
        Route::get('/', [AssetHealthReportController::class, 'index'])->name('index');

        // Menampilkan asset berdasarkan lokasi
        Route::get('/location/{location}', [AssetHealthReportController::class, 'show'])->name('showLocation');

        // Menampilkan laporan berdasarkan lokasi dan report ID
        Route::get('/location/{location}/report/{report}', [AssetHealthReportController::class, 'showReport'])->name('showReport');

        // Menampilkan unit dalam laporan berdasarkan lokasi, report ID, dan unit ID
        Route::get('/location/{location}/report/{report}/unit/{unit}', [AssetHealthReportController::class, 'showReportUnit'])->name('showReportUnit');

        // Mengupdate asset dalam laporan berdasarkan ID
        Route::put('/report/unit/update/{id_reportAssets}', [AssetHealthReportController::class, 'updateReportAssets'])->name('updateReportAssets');

        // Mengedit asset dalam laporan berdasarkan reportAsset ID
        Route::get('/report/edit/{reportAsset}', [AssetHealthReportController::class, 'editReportAsset'])->name('editReportAsset');

        // Menampilkan detail asset berdasarkan report assets ID
        Route::get('/report/detail/{id_report_assets}', [AssetHealthReportController::class, 'detail'])->name('detailReportAsset');

        Route::post('/report/detail/changeStatus', [AssetHealthReportController::class, 'changeStatus'])->name('changeStatus');

        // Menghapus detail asset berdasarkan detail report ID
        Route::delete('/report/detail/delete/{id_detail_report}', [AssetHealthReportController::class, 'deleteDetailReportAsset'])->name('deleteDetailReportAsset');

        // Menambahkan tanggal report baru
        Route::post('/report/add-date', [AssetHealthReportController::class, 'addReportDate'])->name('addReportDate');

        // Mengupdate detail report berdasarkan report detail ID
        Route::put('/report/detail/update/{id_report_detail}', [AssetHealthReportController::class, 'UpdatedetailReports'])->name('updateDetailReport');

        // Menyimpan detail report baru berdasarkan reportAssets ID
        Route::post('/report/detail/store/{id_reportAssets}', [AssetHealthReportController::class, 'StoreDetailReports'])->name('storeDetailReport');

        Route::prefix('/import')->name('import.')->group(function () {
            Route::post('/report', [ImportDataController::class, 'importReportByExcel'])->name('report');
        });


        Route::prefix('/asset-report')->name('assetReport.')->group(function () {
            Route::get('/', [AssetHealthReportController::class, 'assetReport'])->name('index');
            Route::get('/search', [AssetHealthReportController::class, 'searchAssetReport'])->name('searchAssetReport');
            Route::get('/show/{id_report_asset}', [AssetHealthReportController::class, 'showAssetReport'])->name('showAssetReport');
        });
    });

    Route::prefix('/asset-management')->name('assetManagement.')->group(function () {

        Route::prefix('/location')->name('location.')->group(function () {
            Route::get('/', [LocationController::class, 'index'])->name('index');
            Route::post('/store', [LocationController::class, 'store'])->name('store');
            Route::put('/update/{id}', [LocationController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [LocationController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('/unit-pembangkit')->name('unitPembangkit.')->group(function () {
            Route::get('/show/{location_id}', [UnitController::class, 'index'])->name('index');
            Route::post('/store', [UnitController::class, 'store'])->name('store');
            Route::put('/update/{id}', [UnitController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [UnitController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('/assets')->name('assets.')->group(function () {
            Route::get('/show/{unit_id}', [AssetController::class, 'index'])->name('index');
            Route::post('/store', [AssetController::class, 'store'])->name('store');
            Route::put('/update/{id}', [AssetController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [AssetController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('/import')->name('import.')->group(function () {
            Route::post('/asset', [ImportDataController::class, 'importAssetByExcel'])->name('asset');
        });

    });

    Route::prefix('/settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::post('/update-account', [SettingsController::class, 'updateAccount'])->name('updateAccount');
    });

    Route::prefix('/export')->name('export.')->group(function () {
        Route::get('/', [ExportDataController::class, 'index'])->name('index');
        Route::get('/show', [ExportDataController::class, 'show'])->name('show');

    });
});

require __DIR__ . '/auth.php';
