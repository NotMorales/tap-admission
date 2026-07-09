<?php

namespace App\Models;

class AuditLog extends BaseModel
{
    public const COLLECTION = 'audit_logs';

    protected $collection = self::COLLECTION;

    protected $fillable = [
        'module',
        'action',
        'record_id',
        'record_code',
        'old_data',
        'new_data',
        'performed_by',
        'request',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
        'performed_by' => 'array',
        'request' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}
