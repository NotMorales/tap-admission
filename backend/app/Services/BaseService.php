<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\BaseModel;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class BaseService
{
    public function paginate(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository()->paginate($filters, $perPage);
    }

    public function find(string $id): BaseModel
    {
        $record = $this->repository()->find($id);

        if (! $record) {
            throw new NotFoundException($this->notFoundMessage());
        }

        return $record;
    }

    public function create(array $data): BaseModel
    {
        return $this->repository()->create($data);
    }

    public function update(string $id, array $data): BaseModel
    {
        $record = $this->find($id);

        return $this->repository()->update($record, $data);
    }

    public function delete(string $id): bool
    {
        $record = $this->find($id);

        return $this->repository()->delete($record);
    }

    public function restore(string $id): bool
    {
        return $this->repository()->restore($id);
    }

    protected function notFoundMessage(): string
    {
        return 'Resource not found.';
    }

    abstract protected function repository(): BaseRepository;
}
