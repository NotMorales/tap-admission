<?php

use App\Http\Controllers\Api\SectionController;
use Illuminate\Support\Facades\Route;

Route::prefix('sections')->group(function () {

    Route::get('/', [SectionController::class, 'index'])
        ->middleware('permission:/sections,VIEW');

    Route::post('/', [SectionController::class, 'store'])
        ->middleware('permission:/sections,CREATE');

    Route::get('{section}', [SectionController::class, 'show'])
        ->middleware('permission:/sections,VIEW');

    Route::put('{section}', [SectionController::class, 'update'])
        ->middleware('permission:/sections,UPDATE');

    Route::delete('{section}', [SectionController::class, 'destroy'])
        ->middleware('permission:/sections,DELETE');

});
