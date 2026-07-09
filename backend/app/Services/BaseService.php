<?php

namespace App\Services;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseService
{
    public function all(): Collection
    {
        return $this->model()::query()
            ->whereNull('deleted_at')
            ->latest()
            ->get();
    }

    public function find(string $id): ?BaseModel
    {
        return $this->model()::query()
            ->whereNull('deleted_at')
            ->find($id);
    }

    public function create(array $data): BaseModel
    {
        return $this->model()::query()->create($data);
    }

    public function update(string $id, array $data): ?BaseModel
    {
        $record = $this->find($id);

        if (! $record) {
            return null;
        }

        $record->update($data);

        return $record->fresh();
    }

    public function delete(string $id): bool
    {
        $record = $this->find($id);

        if (! $record) {
            return false;
        }

        return (bool) $record->delete();
    }

    abstract protected function model(): string;
}
