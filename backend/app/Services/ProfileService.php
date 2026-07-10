<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use App\Repositories\ProfileRepository;
use App\Models\BaseModel;
use App\Models\Profile;
use App\Support\CodeGenerator;

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

    public function create(array $data): BaseModel
    {
        $data['code'] = CodeGenerator::generate(
            Profile::class,
            'PRF'
        );

        return parent::create($data);
    }
}
