<?php

namespace App\Filters;

class ProductFilter extends BaseFilter
{
    protected function search($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('code', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('brand', 'like', "%{$search}%");
        });
    }
}
