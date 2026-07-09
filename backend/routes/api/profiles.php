<?php

use App\Http\Controllers\Api\Exports\ProfileExportController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('profiles')->group(function () {

    Route::get('/', [ProfileController::class, 'index'])
        ->middleware('permission:/profiles,VIEW');

    Route::post('/', [ProfileController::class, 'store'])
        ->middleware('permission:/profiles,CREATE');

    Route::get('{profile}', [ProfileController::class, 'show'])
        ->middleware('permission:/profiles,VIEW');

    Route::put('{profile}', [ProfileController::class, 'update'])
        ->middleware('permission:/profiles,UPDATE');

    Route::delete('{profile}', [ProfileController::class, 'destroy'])
        ->middleware('permission:/profiles,DELETE');

    Route::get('export/csv', [ProfileExportController::class, 'csv'])
        ->middleware('permission:/profiles,EXPORT');

    Route::get('export/pdf', [ProfileExportController::class, 'pdf'])
        ->middleware('permission:/profiles,EXPORT');

});
