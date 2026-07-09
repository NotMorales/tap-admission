<?php

namespace App\Exports;

use App\Models\Product;

class ProductsExport extends BaseExport
{
    protected function headers(): array
    {
        return [
            'Código',
            'Nombre',
            'Marca',
            'Precio',
            'Estado',
        ];
    }

    protected function rows(): array
    {
        return Product::query()
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get()
            ->map(function ($product) {
                return [
                    $product->code,
                    $product->name,
                    $product->brand,
                    $product->price,
                    $product->status instanceof \BackedEnum
                        ? $product->status->value
                        : (string) $product->status,
                ];
            })
            ->toArray();
    }

    protected function filename(): string
    {
        return 'products';
    }
}
