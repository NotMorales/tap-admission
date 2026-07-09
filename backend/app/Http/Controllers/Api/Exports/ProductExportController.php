<?php

namespace App\Http\Controllers\Api\Exports;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;

class ProductExportController extends Controller
{
    public function csv()
    {
        return (new ProductsExport())->downloadCsv();
    }
}
