<?php

use App\Http\Controllers\Api\AuditLogController;
use Illuminate\Support\Facades\Route;

Route::prefix('audit-logs')->group(function () {

    Route::get('/', [AuditLogController::class, 'index'])
        ->middleware('permission:/audit-logs,VIEW');

    Route::get('{auditLog}', [AuditLogController::class, 'show'])
        ->middleware('permission:/audit-logs,VIEW');

});
