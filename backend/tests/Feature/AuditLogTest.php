<?php

namespace Tests\Feature;

class AuditLogTest extends ApiTestCase
{
    public function test_user_can_list_audit_logs(): void
    {
        $this->postJson('/api/products', [
            'code' => 'PROD-AUDIT-01',
            'name' => 'Producto Audit',
            'brand' => 'TAP',
            'price' => 100,
            'status' => 'ACTIVE',
        ], $this->authHeaders());

        $this->getJson('/api/audit-logs', $this->authHeaders())
            ->assertOk()
            ->assertJsonPath('success', true);
    }

    public function test_user_can_show_audit_log(): void
    {
        $this->postJson('/api/products', [
            'code' => 'PROD-AUDIT-02',
            'name' => 'Producto Audit 2',
            'brand' => 'TAP',
            'price' => 100,
            'status' => 'ACTIVE',
        ], $this->authHeaders());

        $auditId = $this->getJson('/api/audit-logs', $this->authHeaders())->json('data.0.id');

        $this->getJson('/api/audit-logs/' . $auditId, $this->authHeaders())
            ->assertOk()
            ->assertJsonPath('success', true);
    }
}
