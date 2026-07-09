<?php

namespace App\Repositories;

use App\Filters\BaseFilter;
use App\Filters\ProductFilter;
use App\Models\Product;

class ProductRepository extends BaseRepository
{
    protected function model(): string
    {
        return Product::class;
    }

    protected function filter(): BaseFilter
    {
        return new ProductFilter();
    }

    public function allForExport()
    {
        return $this->query()
            ->orderBy('name')
            ->get();
    }
}
