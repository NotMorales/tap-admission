<?php

namespace App\Filters;

class AuditLogFilter extends BaseFilter
{
    protected function search($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('module', 'like', "%{$search}%")
                ->orWhere('action', 'like', "%{$search}%")
                ->orWhere('record_code', 'like', "%{$search}%");
        });
    }
}
