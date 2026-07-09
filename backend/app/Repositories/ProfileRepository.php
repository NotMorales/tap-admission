<?php

namespace App\Repositories;

use App\Filters\BaseFilter;
use App\Filters\ProfileFilter;
use App\Models\Profile;

class ProfileRepository extends BaseRepository
{
    protected function model(): string
    {
        return Profile::class;
    }

    protected function filter(): BaseFilter
    {
        return new ProfileFilter();
    }
}
