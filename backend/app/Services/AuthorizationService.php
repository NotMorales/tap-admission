<?php

namespace App\Services;

use App\Models\Profile;
use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Collection;

class AuthorizationService
{
    public function profiles(User $user): Collection
    {
        return Profile::query()
            ->whereIn('_id', $user->profile_ids ?? [])
            ->whereNull('deleted_at')
            ->get();
    }

    public function sections(User $user): Collection
    {
        $profiles = $this->profiles($user);

        $sectionIds = $profiles
            ->pluck('permissions')
            ->flatten(1)
            ->pluck('section_id')
            ->unique()
            ->values()
            ->toArray();

        return Section::query()
            ->whereIn('_id', $sectionIds)
            ->whereNull('deleted_at')
            ->orderBy('order')
            ->get()
            ->map(function ($section) use ($profiles) {
                $actions = $profiles
                    ->pluck('permissions')
                    ->flatten(1)
                    ->where('section_id', (string) $section->_id)
                    ->pluck('actions')
                    ->flatten()
                    ->unique()
                    ->values()
                    ->toArray();

                $section->allowed_actions = $actions;

                return $section;
            });
    }

    public function context(User $user): array
    {
        return [
            'user' => $user,
            'profiles' => $this->profiles($user),
            'sections' => $this->sections($user),
        ];
    }
}
