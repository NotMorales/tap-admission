<?php

namespace App\Pdf;

use Illuminate\Support\Collection;

class ProductPdf extends BasePdf
{
    public function __construct(Collection $products)
    {
        $this->view = 'exports.products-pdf';
        $this->fileName = 'products.pdf';
        $this->data = compact('products');
    }
}
