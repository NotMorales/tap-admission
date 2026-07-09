<?php

namespace App\Repositories;

use App\Models\BaseModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class BaseRepository
{
    public function paginate(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model()::query()->whereNull('deleted_at');

        if (! empty($filters['search'])) {
            $query = $this->applySearch($query, $filters['search']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $sort = $filters['sort'] ?? 'created_at';
        $direction = $filters['direction'] ?? 'desc';

        return $query->orderBy($sort, $direction)->paginate($perPage);
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

    public function update(BaseModel $model, array $data): BaseModel
    {
        $model->update($data);

        return $model->fresh();
    }

    public function delete(BaseModel $model): bool
    {
        return (bool) $model->delete();
    }

    public function restore(string $id): bool
    {
        $record = $this->model()::withTrashed()->find($id);

        if (! $record) {
            return false;
        }

        return (bool) $record->restore();
    }

    abstract protected function model(): string;

    abstract protected function filter(): \App\Filters\BaseFilter;
}
