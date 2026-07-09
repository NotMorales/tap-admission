<?php

use App\Http\Controllers\Api\Exports\UserExportController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserPhotoController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {

    Route::get('/', [UserController::class, 'index'])
        ->middleware('permission:/users,VIEW');

    Route::post('/', [UserController::class, 'store'])
        ->middleware('permission:/users,CREATE');

    Route::get('{user}', [UserController::class, 'show'])
        ->middleware('permission:/users,VIEW');

    Route::put('{user}', [UserController::class, 'update'])
        ->middleware('permission:/users,UPDATE');

    Route::delete('{user}', [UserController::class, 'destroy'])
        ->middleware('permission:/users,DELETE');

    Route::post('{user}/photo', [UserPhotoController::class, 'upload'])
        ->middleware('permission:/users,UPDATE');

    Route::get('export/csv', [UserExportController::class, 'csv'])
        ->middleware('permission:/users,EXPORT');

    Route::get('export/pdf', [UserExportController::class, 'pdf'])
        ->middleware('permission:/users,EXPORT');

});
