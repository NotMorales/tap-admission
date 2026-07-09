<?php

namespace Tests\Feature;

class UserTest extends ApiTestCase
{
    public function test_user_can_list_users(): void
    {
        $this->getJson('/api/users', $this->authHeaders())
            ->assertOk()
            ->assertJsonPath('success', true);
    }

    public function test_user_can_create_user(): void
    {
        $profileId = $this->getJson('/api/profiles', $this->authHeaders())->json('data.0.id');

        $this->postJson('/api/users', [
            'code' => 'USR-TEST-01',
            'name' => 'Usuario Test',
            'email' => 'user.test@tap.test',
            'password' => 'Password123',
            'phone' => '+529211111111',
            'photo' => null,
            'profile_ids' => [$profileId],
            'status' => 'ACTIVE',
        ], $this->authHeaders())
            ->assertCreated()
            ->assertJsonPath('data.email', 'user.test@tap.test');
    }

    public function test_user_can_update_user(): void
    {
        $id = $this->getJson('/api/users', $this->authHeaders())->json('data.0.id');

        $this->putJson('/api/users/' . $id, [
            'name' => 'Usuario Actualizado',
        ], $this->authHeaders())
            ->assertOk()
            ->assertJsonPath('data.name', 'Usuario Actualizado');
    }

    public function test_user_can_delete_user(): void
    {
        $id = $this->getJson('/api/users', $this->authHeaders())->json('data.0.id');

        $this->deleteJson('/api/users/' . $id, [], $this->authHeaders())
            ->assertOk()
            ->assertJsonPath('success', true);
    }
}
