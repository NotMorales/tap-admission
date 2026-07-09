<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Section;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Tests\TestCase;

abstract class ApiTestCase extends TestCase
{
    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cleanDatabase();
        $this->seed(DatabaseSeeder::class);

        $this->token = $this->loginAsAdmin();
    }

    protected function cleanDatabase(): void
    {
        AuditLog::truncate();
        Product::truncate();
        User::truncate();
        Profile::truncate();
        Section::truncate();
    }

    protected function loginAsAdmin(): string
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'admin@tap.test',
            'password' => 'Password123',
        ]);

        return $response->json('data.access_token');
    }

    protected function authHeaders(): array
    {
        return [
            'Authorization' => 'Bearer '.$this->token,
            'Accept' => 'application/json',
        ];
    }
}
