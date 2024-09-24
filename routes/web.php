<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetHealthReportController;
use App\Http\Controllers\AssetManagementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//    return redirect('/login');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });



Route::get('/', function () {
    return redirect('/login');
});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

 Route::prefix('/dashboard')->name('dashboard.')->middleware(['auth', 'verified'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        // Route::get('/', [DashboardController::class, 'index'])->name('index');
    });


Route::middleware(['auth'])->group(function () {

    // Route::prefix('/dashboard')->name('dashboard.')->group(function () {
    //     Route::get('/', [DashboardController::class, 'index'])->name('index');
    //     // Route::get('/', [DashboardController::class, 'index'])->name('index');
    // });

    Route::prefix('/asset-health-report')->name('assetHealthReport.')->group(function () {
        Route::get('/', [AssetHealthReportController::class, 'index'])->name('index');
        Route::get('/{location}', [AssetHealthReportController::class, 'locationDetail'])->name('locationDetail');
        // Route::post('/', [LocationController::class, 'store'])->name('store');
        // Route::put('/update/{id}', [LocationController::class, 'update'])->name('update');
        // Route::delete('/delete/{id}', [LocationController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('/asset-management')->name('assetManagement.')->group(function () {
        Route::get('/', [AssetManagementController::class, 'index'])->name('index');
        // Route::post('/', [UnitController::class, 'store'])->name('store');
        // Route::put('/update/{id}', [UnitController::class, 'update'])->name('update');
        // Route::delete('/delete/{id}', [UnitController::class, 'destroy'])->name('destroy');
    });
    // Route::prefix('/system-engine')->name('system-engine.')->group(function () {
    //     Route::get('/', [SystemController::class, 'index'])->name('index');
    //     Route::post('/', [SystemController::class, 'store'])->name('store');
    //     Route::put('/update/{id}', [SystemController::class, 'update'])->name('update');
    //     Route::delete('/delete/{id}', [SystemController::class, 'destroy'])->name('destroy');
    // });
    // Route::prefix('/asset')->name('asset.')->group(function () {
    //     Route::get('/', [AssetController::class, 'index'])->name('index');
    //     Route::post('/', [AssetController::class, 'store'])->name('store');
    //     Route::put('/update/{id}', [AssetController::class, 'update'])->name('update');
    //     Route::delete('/delete/{id}', [AssetController::class, 'destroy'])->name('destroy');
    // });
});

require __DIR__.'/auth.php';
