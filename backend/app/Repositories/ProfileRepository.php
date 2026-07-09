<?php

namespace App\Repositories;

use App\Models\Profile;

class ProfileRepository extends BaseRepository
{
    protected function model(): string
    {
        return Profile::class;
    }

    protected function applySearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('code', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%");
        });
    }
}
