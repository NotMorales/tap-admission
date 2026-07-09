<?php

namespace App\Exports;

use App\Models\Profile;

class ProfilesExport extends BaseExport
{
    protected function headers(): array
    {
        return [
            'Código',
            'Nombre',
            'Fecha creación',
        ];
    }

    protected function rows(): array
    {
        return Profile::query()
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get()
            ->map(fn ($profile) => [
                $profile->code,
                $profile->name,
                optional($profile->created_at)->format('d/m/Y H:i'),
            ])
            ->toArray();
    }

    protected function filename(): string
    {
        return 'profiles';
    }
}
