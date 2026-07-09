<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use App\Repositories\ProfileRepository;

class ProfileService extends BaseService
{
    public function __construct(
        private readonly ProfileRepository $profileRepository
    ) {}

    protected function auditModule(): string
    {
        return 'PROFILES';
    }

    protected function repository(): BaseRepository
    {
        return $this->profileRepository;
    }

    protected function notFoundMessage(): string
    {
        return 'Profile not found.';
    }

    public function allForExport()
    {
        return $this->repository()->allForExport();
    }
}
