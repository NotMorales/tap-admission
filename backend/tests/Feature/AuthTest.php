<?php

namespace Tests\Feature;

class AuthTest extends ApiTestCase
{
    public function test_user_can_login_with_valid_credentials(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'admin@tap.test',
            'password' => 'Password123',
        ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'access_token',
                    'token_type',
                    'expires_in',
                    'user',
                    'profiles',
                    'sections',
                ],
                'errors',
                'meta',
            ]);
    }

    public function test_user_can_get_authenticated_context(): void
    {
        $response = $this->getJson('/api/auth/me', $this->authHeaders());

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'data' => [
                    'user',
                    'profiles',
                    'sections',
                ],
            ]);
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'admin@tap.test',
            'password' => 'wrong-password',
        ]);

        $response->assertUnauthorized()
            ->assertJsonPath('success', false);
    }

    public function test_user_can_logout(): void
    {
        $response = $this->postJson('/api/auth/logout', [], $this->authHeaders());

        $response->assertOk()
            ->assertJsonPath('success', true);
    }
}
