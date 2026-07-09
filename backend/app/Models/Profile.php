<?php

namespace App\Models;

use App\Enums\ProfileStatus;

class Profile extends BaseModel
{
    public const COLLECTION = 'profiles';

    protected $collection = self::COLLECTION;

    protected $fillable = [
        'code',
        'name',
        'section_ids',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'section_ids' => 'array',
        'status' => ProfileStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}
