<?php

namespace Tests\Feature;

class SectionTest extends ApiTestCase
{
    public function test_user_can_list_sections(): void
    {
        $this->getJson('/api/sections', $this->authHeaders())
            ->assertOk()
            ->assertJsonPath('success', true);
    }

    public function test_user_can_create_section(): void
    {
        $this->postJson('/api/sections', [
            'code' => 'SEC-TEST-01',
            'name' => 'Sección Test',
            'route' => '/test-section',
            'icon' => 'science',
            'permissions' => ['VIEW', 'CREATE', 'UPDATE', 'DELETE', 'EXPORT'],
            'order' => 99,
            'status' => 'ACTIVE',
        ], $this->authHeaders())
            ->assertCreated()
            ->assertJsonPath('data.code', 'SEC-TEST-01');
    }

    public function test_user_can_update_section(): void
    {
        $id = $this->getJson('/api/sections', $this->authHeaders())->json('data.0.id');

        $this->putJson('/api/sections/' . $id, [
            'name' => 'Sección Actualizada',
        ], $this->authHeaders())
            ->assertOk()
            ->assertJsonPath('data.name', 'Sección Actualizada');
    }

    public function test_user_can_delete_section(): void
    {
        $id = $this->getJson('/api/sections', $this->authHeaders())->json('data.0.id');

        $this->deleteJson('/api/sections/' . $id, [], $this->authHeaders())
            ->assertOk()
            ->assertJsonPath('success', true);
    }
}
