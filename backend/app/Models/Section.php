<?php

namespace App\Models;

use App\Enums\SectionStatus;

class Section extends BaseModel
{
    public const COLLECTION = 'sections';
    protected $collection = self::COLLECTION;

    protected $casts = [
        'permissions' => 'array',
        'status' => SectionStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $fillable = [
        'code',
        'name',
        'route',
        'icon',
        'permissions',
        'order',
        'status'
    ];
}
