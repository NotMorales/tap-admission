<?php

use Illuminate\Support\Facades\Route;

require __DIR__ . '/api/auth.php';

Route::middleware('auth:api')->group(function () {
    require __DIR__ . '/api/sections.php';
    require __DIR__ . '/api/profiles.php';
    require __DIR__ . '/api/users.php';
    require __DIR__ . '/api/products.php';
    require __DIR__ . '/api/audit-logs.php';
});
