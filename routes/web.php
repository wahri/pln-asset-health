<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetHealthReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::prefix('/dashboard')->name('dashboard.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
});

Route::middleware(['auth'])->group(function () {

    Route::prefix('/asset-health-report')->name('assetHealthReport.')->group(function () {
        Route::get('/', [AssetHealthReportController::class, 'index'])->name('index');
        Route::get('/{location}', [AssetHealthReportController::class, 'show'])->name('reportAssets.show');
        Route::get('/detail/{id_report_assets}', [AssetHealthReportController::class, 'detail'])->name('reportAssets.detail');

        Route::post('/add-report-date', [AssetHealthReportController::class, 'addReportDate'])->name('addReportDate');
        Route::put('/update-detail-Reports/{id_report_detail}', [AssetHealthReportController::class, 'UpdatedetailReports'])->name('reportAssets.UpdatedetailReports');

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
            Route::post('/', [AssetController::class, 'store'])->name('store');
            Route::put('/update/{id}', [AssetController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [AssetController::class, 'destroy'])->name('destroy');
        });
    });
});

require __DIR__.'/auth.php';
