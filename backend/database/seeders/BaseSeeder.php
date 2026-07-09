<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

abstract class BaseSeeder extends Seeder
{
    protected function seed(string $model, string $uniqueField, array $records): void
    {
        foreach ($records as $record) {
            $model::query()->updateOrCreate(
                [
                    $uniqueField => $record[$uniqueField],
                ],
                $record
            );
        }
    }
}
