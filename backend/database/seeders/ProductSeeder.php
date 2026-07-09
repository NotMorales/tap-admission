<?php

namespace Database\Seeders;

use App\Enums\ProductStatus;
use App\Models\Product;

class ProductSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->seed(
            Product::class,
            'code',
            [
                [
                    'code' => 'PROD-000001',
                    'name' => 'Aceite Hidráulico',
                    'brand' => 'Mobil',
                    'price' => 250,
                    'status' => ProductStatus::ACTIVE->value,
                ],
                [
                    'code' => 'PROD-000002',
                    'name' => 'Filtro de Aire',
                    'brand' => 'Fleetguard',
                    'price' => 180,
                    'status' => ProductStatus::ACTIVE->value,
                ],
                [
                    'code' => 'PROD-000003',
                    'name' => 'Grasa Industrial',
                    'brand' => 'Shell',
                    'price' => 320,
                    'status' => ProductStatus::ACTIVE->value,
                ],
            ]
        );
    }
}
