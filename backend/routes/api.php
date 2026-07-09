<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\Exports\ProductExportController;
use App\Http\Controllers\Api\AuditLogController;


Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::middleware('auth:api')->group(function () {
    // Sections
    Route::get('sections', [SectionController::class, 'index'])
        ->middleware('permission:/sections,VIEW');
    Route::post('sections', [SectionController::class, 'store'])
        ->middleware('permission:/sections,CREATE');
    Route::get('sections/{section}', [SectionController::class, 'show'])
        ->middleware('permission:/sections,VIEW');
    Route::put('sections/{section}', [SectionController::class, 'update'])
        ->middleware('permission:/sections,UPDATE');
    Route::delete('sections/{section}', [SectionController::class, 'destroy'])
        ->middleware('permission:/sections,DELETE');

    // Profiles
    Route::get('profiles', [ProfileController::class, 'index'])
        ->middleware('permission:/profiles,VIEW');
    Route::post('profiles', [ProfileController::class, 'store'])
        ->middleware('permission:/profiles,CREATE');
    Route::get('profiles/{profile}', [ProfileController::class, 'show'])
        ->middleware('permission:/profiles,VIEW');
    Route::put('profiles/{profile}', [ProfileController::class, 'update'])
        ->middleware('permission:/profiles,UPDATE');
    Route::delete('profiles/{profile}', [ProfileController::class, 'destroy'])
        ->middleware('permission:/profiles,DELETE');

    // Users
    Route::get('users', [UserController::class, 'index'])
        ->middleware('permission:/users,VIEW');
    Route::post('users', [UserController::class, 'store'])
        ->middleware('permission:/users,CREATE');
    Route::get('users/{user}', [UserController::class, 'show'])
        ->middleware('permission:/users,VIEW');
    Route::put('users/{user}', [UserController::class, 'update'])
        ->middleware('permission:/users,UPDATE');
    Route::delete('users/{user}', [UserController::class, 'destroy'])
        ->middleware('permission:/users,DELETE');

    // Products
    Route::get('products', [ProductController::class, 'index'])
        ->middleware('permission:/products,VIEW');
    Route::post('products', [ProductController::class, 'store'])
        ->middleware('permission:/products,CREATE');
    Route::get('products/{product}', [ProductController::class, 'show'])
        ->middleware('permission:/products,VIEW');
    Route::put('products/{product}', [ProductController::class, 'update'])
        ->middleware('permission:/products,UPDATE');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])
        ->middleware('permission:/products,DELETE');

    Route::get('products/export/csv', [ProductExportController::class, 'csv'])
        ->middleware('permission:/products,EXPORT');

    Route::get('audit-logs', [AuditLogController::class, 'index'])
        ->middleware('permission:/audit-logs,VIEW');

    Route::get('audit-logs/{auditLog}', [AuditLogController::class, 'show'])
        ->middleware('permission:/audit-logs,VIEW');
});
