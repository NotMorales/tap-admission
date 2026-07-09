<?php

namespace App\Repositories;

use App\Models\Section;

class SectionRepository extends BaseRepository
{
    protected function model(): string
    {
        return Section::class;
    }

    protected function applySearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('code', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('route', 'like', "%{$search}%");
        });
    }
}
