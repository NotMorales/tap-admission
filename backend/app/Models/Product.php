<?php

namespace App\Models;

use App\Enums\ProductStatus;

class Product extends BaseModel
{
    public const COLLECTION = 'products';

    protected $collection = self::COLLECTION;

    protected $fillable = [
        'code',
        'name',
        'brand',
        'price',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'price' => 'integer',
        'status' => ProductStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}
