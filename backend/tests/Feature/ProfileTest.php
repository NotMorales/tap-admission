<?php

namespace Tests\Feature;

class ProfileTest extends ApiTestCase
{
    public function test_user_can_list_profiles(): void
    {
        $this->getJson('/api/profiles', $this->authHeaders())
            ->assertOk()
            ->assertJsonPath('success', true);
    }

    public function test_user_can_create_profile(): void
    {
        $sectionId = $this->getJson('/api/sections', $this->authHeaders())->json('data.0.id');

        $this->postJson('/api/profiles', [
            'code' => 'PRF-TEST-01',
            'name' => 'Perfil Test',
            'permissions' => [
                [
                    'section_id' => $sectionId,
                    'actions' => ['VIEW', 'CREATE'],
                ],
            ],
            'status' => 'ACTIVE',
        ], $this->authHeaders())
            ->assertCreated()
            ->assertJsonPath('data.code', 'PRF-TEST-01');
    }

    public function test_user_can_update_profile(): void
    {
        $id = $this->getJson('/api/profiles', $this->authHeaders())->json('data.0.id');

        $this->putJson('/api/profiles/' . $id, [
            'name' => 'Perfil Actualizado',
        ], $this->authHeaders())
            ->assertOk()
            ->assertJsonPath('data.name', 'Perfil Actualizado');
    }

    public function test_user_can_delete_profile(): void
    {
        $id = $this->getJson('/api/profiles', $this->authHeaders())->json('data.0.id');

        $this->deleteJson('/api/profiles/' . $id, [], $this->authHeaders())
            ->assertOk()
            ->assertJsonPath('success', true);
    }
}
