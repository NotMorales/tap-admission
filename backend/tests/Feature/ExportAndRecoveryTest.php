<?php

namespace Tests\Feature;

class ExportAndRecoveryTest extends ApiTestCase
{
    public function test_user_can_export_products_pdf(): void
    {
        $this->get('/api/products/export/pdf', $this->authHeaders())
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }

    public function test_user_can_export_users_pdf(): void
    {
        $this->get('/api/users/export/pdf', $this->authHeaders())
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }

    public function test_user_can_export_profiles_pdf(): void
    {
        $this->get('/api/profiles/export/pdf', $this->authHeaders())
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }

    public function test_user_can_export_products_csv(): void
    {
        $this->get('/api/products/export/csv', $this->authHeaders())
            ->assertOk();
    }

    public function test_user_can_export_users_csv(): void
    {
        $this->get('/api/users/export/csv', $this->authHeaders())
            ->assertOk();
    }

    public function test_user_can_export_profiles_csv(): void
    {
        $this->get('/api/profiles/export/csv', $this->authHeaders())
            ->assertOk();
    }

    public function test_user_can_recover_password(): void
    {
        $response = $this->postJson('/api/auth/recover-password', [
            'email' => 'admin@tap.test',
        ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'data' => [
                    'email',
                    'temporary_password',
                    'note',
                ],
            ]);
    }
}
