<?php

namespace App\Models;

use App\Traits\HasUserTracking;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Eloquent\SoftDeletes;

abstract class BaseModel extends Model
{
    use SoftDeletes;
    use HasUserTracking;

    protected $connection = 'mongodb';

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'created_by' => 'string',
        'updated_by' => 'string',
        'deleted_by' => 'string',
    ];

    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function scopeOrdered($query, string $field = 'created_at', string $direction = 'desc')
    {
        return $query->orderBy($field, $direction);
    }
}
