<?php

namespace Tests\Feature;

use App\Enums\UserStatus;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthorizationTest extends ApiTestCase
{
    public function test_request_without_token_is_rejected(): void
    {
        auth('api')->logout();

        $this->getJson('/api/products', [
            'Accept' => 'application/json',
        ])->assertUnauthorized();
    }

    public function test_user_with_consulta_profile_cannot_create_product(): void
    {
        $consultaProfile = Profile::where('code', 'PRF-000003')->first();

        User::query()->create([
            'code' => 'USR-CONSULTA',
            'name' => 'Usuario Consulta',
            'email' => 'consulta@tap.test',
            'password' => Hash::make('Password123'),
            'phone' => '+529211111111',
            'photo' => null,
            'profile_ids' => [(string) $consultaProfile->_id],
            'status' => UserStatus::ACTIVE->value,
        ]);

        $login = $this->postJson('/api/auth/login', [
            'email' => 'consulta@tap.test',
            'password' => 'Password123',
        ]);

        $token = $login->json('data.access_token');

        $this->postJson('/api/products', [
            'name' => 'Producto Sin Permiso',
            'brand' => 'TAP',
            'price' => 100,
            'status' => 'ACTIVE',
        ], [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->assertForbidden();
    }

    public function test_user_with_consulta_profile_can_list_products(): void
    {
        $consultaProfile = Profile::where('code', 'PRF-000003')->first();

        User::query()->create([
            'code' => 'USR-CONSULTA-2',
            'name' => 'Usuario Consulta 2',
            'email' => 'consulta2@tap.test',
            'password' => Hash::make('Password123'),
            'phone' => '+529211111112',
            'photo' => null,
            'profile_ids' => [(string) $consultaProfile->_id],
            'status' => UserStatus::ACTIVE->value,
        ]);

        $login = $this->postJson('/api/auth/login', [
            'email' => 'consulta2@tap.test',
            'password' => 'Password123',
        ]);

        $token = $login->json('data.access_token');

        $this->getJson('/api/products', [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->assertOk();
    }
}
