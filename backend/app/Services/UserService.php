<?php

namespace App\Services;

use App\Models\BaseModel;
use App\Repositories\BaseRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Support\CodeGenerator;

class UserService extends BaseService
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {}

    protected function auditModule(): string
    {
        return 'USERS';
    }

    protected function repository(): BaseRepository
    {
        return $this->userRepository;
    }

    public function create(array $data): BaseModel
    {
        $data['code'] = CodeGenerator::generate(User::class, 'USR');

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return parent::create($data);
    }

    public function update(string $id, array $data): BaseModel
    {
        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        return parent::update($id, $data);
    }

    protected function notFoundMessage(): string
    {
        return 'User not found.';
    }

    public function allForExport()
    {
        return $this->repository()->allForExport();
    }
}
