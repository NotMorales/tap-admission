<?php

namespace App\Http\Controllers\Api\Exports;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Pdf\ProductPdf;
use App\Services\AuditLogService;
use App\Services\ProductService;

class ProductExportController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
        private readonly AuditLogService $auditLogService,
    ) {}

    public function csv()
    {
        $this->auditLogService->record('PRODUCTS', 'EXPORT');

        return (new ProductsExport)->downloadCsv();
    }

    public function pdf()
    {
        $products = $this->productService->allForExport();

        $this->auditLogService->record('PRODUCTS', 'EXPORT');

        return (new ProductPdf($products))->download();
    }
}
