<?php

namespace App\Filters;

abstract class BaseFilter
{
    public function apply($query, array $filters)
    {
        if (! empty($filters['search'])) {
            $query = $this->search($query, $filters['search']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query;
    }

    abstract protected function search($query, string $search);
}
