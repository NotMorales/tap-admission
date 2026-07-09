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
        $record = $this->repository()->create($data);

        app(AuditLogService::class)->record(
            module: $this->auditModule(),
            action: 'CREATE',
            model: $record,
            oldData: [],
            newData: $record->toArray()
        );

        return $record;
    }

    public function update(string $id, array $data): BaseModel
    {
        $record = $this->find($id);
        $oldData = $record->toArray();

        $updated = $this->repository()->update($record, $data);

        app(AuditLogService::class)->record(
            module: $this->auditModule(),
            action: 'UPDATE',
            model: $updated,
            oldData: $oldData,
            newData: $updated->toArray()
        );

        return $updated;
    }

    public function delete(string $id): bool
    {
        $record = $this->find($id);
        $oldData = $record->toArray();

        $deleted = $this->repository()->delete($record);

        app(AuditLogService::class)->record(
            module: $this->auditModule(),
            action: 'DELETE',
            model: $record,
            oldData: $oldData,
            newData: []
        );

        return $deleted;
    }

    public function restore(string $id): bool
    {
        return $this->repository()->restore($id);
    }

    protected function auditModule(): string
    {
        return 'GENERAL';
    }

    protected function notFoundMessage(): string
    {
        return 'Resource not found.';
    }

    abstract protected function repository(): BaseRepository;
}
