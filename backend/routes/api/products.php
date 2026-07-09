<?php

use App\Http\Controllers\Api\Exports\ProductExportController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {

    Route::get('/', [ProductController::class, 'index'])
        ->middleware('permission:/products,VIEW');

    Route::post('/', [ProductController::class, 'store'])
        ->middleware('permission:/products,CREATE');

    Route::get('{product}', [ProductController::class, 'show'])
        ->middleware('permission:/products,VIEW');

    Route::put('{product}', [ProductController::class, 'update'])
        ->middleware('permission:/products,UPDATE');

    Route::delete('{product}', [ProductController::class, 'destroy'])
        ->middleware('permission:/products,DELETE');

    Route::get('export/csv', [ProductExportController::class, 'csv'])
        ->middleware('permission:/products,EXPORT');

    Route::get('export/pdf', [ProductExportController::class, 'pdf'])
        ->middleware('permission:/products,EXPORT');

});
