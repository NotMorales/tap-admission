<?php

namespace App\Repositories;

use App\Filters\AuditLogFilter;
use App\Filters\BaseFilter;
use App\Models\AuditLog;

class AuditLogRepository extends BaseRepository
{
    protected function model(): string
    {
        return AuditLog::class;
    }

    protected function filter(): BaseFilter
    {
        return new AuditLogFilter;
    }
}
