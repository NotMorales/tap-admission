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
            ->pluck('section_ids')
            ->flatten()
            ->unique()
            ->values()
            ->toArray();

        return Section::query()
            ->whereIn('_id', $sectionIds)
            ->whereNull('deleted_at')
            ->orderBy('order')
            ->get();
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
