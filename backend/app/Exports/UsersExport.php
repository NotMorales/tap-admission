<?php

namespace App\Exports;

use App\Models\User;

class UsersExport extends BaseExport
{
    protected function headers(): array
    {
        return [
            'Código',
            'Usuario',
            'Nombre',
            'Teléfono',
            'Fecha creación',
        ];
    }

    protected function rows(): array
    {
        return User::query()
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get()
            ->map(fn ($user) => [
                $user->code,
                $user->email,
                $user->name,
                $user->phone,
                optional($user->created_at)->format('d/m/Y H:i'),
            ])
            ->toArray();
    }

    protected function filename(): string
    {
        return 'users';
    }
}
