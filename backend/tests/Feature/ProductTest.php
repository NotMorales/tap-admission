<?php

namespace Tests\Feature;

class ProductTest extends ApiTestCase
{
    public function test_user_can_list_products(): void
    {
        $response = $this->getJson('/api/products', $this->authHeaders());

        $response->assertOk()
            ->assertJsonPath('success', true);
    }

    public function test_user_can_create_product(): void
    {
        $response = $this->postJson('/api/products', [
            'name' => 'Producto Test',
            'brand' => 'TAP',
            'price' => 250,
            'status' => 'ACTIVE',
        ], $this->authHeaders());

        $response->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.name', 'Producto Test');
    }

    public function test_user_can_update_product(): void
    {
        $productId = $this->getJson('/api/products', $this->authHeaders())
            ->json('data.0.id');

        $response = $this->putJson('/api/products/' . $productId, [
            'price' => 300,
        ], $this->authHeaders());

        $response->assertOk()
            ->assertJsonPath('data.price', 300);
    }

    public function test_user_can_delete_product(): void
    {
        $productId = $this->getJson('/api/products', $this->authHeaders())
            ->json('data.0.id');

        $response = $this->deleteJson('/api/products/' . $productId, [], $this->authHeaders());

        $response->assertOk()
            ->assertJsonPath('success', true);
    }
}
