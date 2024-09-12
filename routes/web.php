<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware([])->group(function () {

    Route::prefix('/dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
         Route::get('/', [DashboardController::class, 'index'])->name('index');
    });

    Route::prefix('/location-unit')->name('location-unit.')->group(function () {
        Route::get('/', [LocationController::class, 'index'])->name('index');
        Route::post('/', [LocationController::class, 'store'])->name('store');
        Route::put('/update/{id}', [LocationController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [LocationController::class, 'destroy'])->name('destroy');
       
    });

    Route::prefix('/unit-engine')->name('unit-engine.')->group(function () {
        Route::get('/', [UnitController::class, 'index'])->name('index');
        Route::post('/', [UnitController::class, 'store'])->name('store');
        Route::put('/update/{id}', [UnitController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UnitController::class, 'destroy'])->name('destroy');
    });
});
