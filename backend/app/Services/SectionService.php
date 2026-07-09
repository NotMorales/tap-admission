<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use App\Repositories\SectionRepository;

class SectionService extends BaseService
{
    public function __construct(
        private readonly SectionRepository $sectionRepository
    ) {}

    protected function auditModule(): string
    {
        return 'SECTIONS';
    }

    protected function repository(): BaseRepository
    {
        return $this->sectionRepository;
    }

    protected function notFoundMessage(): string
    {
        return 'Section not found.';
    }
}
