<?php

namespace App\Repositories;

use App\Filters\BaseFilter;
use App\Filters\UserFilter;
use App\Models\User;

class UserRepository extends BaseRepository
{
    protected function model(): string
    {
        return User::class;
    }

    protected function filter(): BaseFilter
    {
        return new UserFilter;
    }

    protected function applySearch($query, string $search)
    {
        return $query;
    }

    public function allForExport()
    {
        return $this->query()
            ->orderBy('name')
            ->get();
    }
}
