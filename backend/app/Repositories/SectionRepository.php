<?php

namespace App\Repositories;

use App\Filters\BaseFilter;
use App\Filters\SectionFilter;
use App\Models\Section;

class SectionRepository extends BaseRepository
{
    protected function model(): string
    {
        return Section::class;
    }

    protected function filter(): BaseFilter
    {
        return new SectionFilter;
    }
}
