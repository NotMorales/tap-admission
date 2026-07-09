<?php

namespace Database\Seeders;

use App\Enums\UserStatus;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminProfile = Profile::where('code', 'PRF-000001')->first();

        User::query()->updateOrCreate(
            [
                'code' => 'USR-000001',
                'name' => 'Administrador',
                'email' => 'admin@tap.test',
                'password' => Hash::make('Password123'),
                'phone' => '+52 9210000000',
                'photo' => null,
                'profile_ids' => $adminProfile ? [(string) $adminProfile->_id] : [],
                'status' => UserStatus::ACTIVE->value,
            ]
        );
    }
}
