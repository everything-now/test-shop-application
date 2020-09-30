<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsEndpointTest extends TestCase
{
    use RefreshDatabase;

    public $endpoint = '/api/products';

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Test Get Products
     *
     * @return void
     */
    public function testGetProducts()
    {
        $response = $this->get($this->endpoint);

        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
        $response->assertJsonStructure(['data' => ['*' => ['id', 'name', 'imageUrl']]]);
    }

    /**
     * Test Post Products
     *
     * @return void
     */
    public function testPostProducts()
    {
        $response = $this->post($this->endpoint);

        $this->assertStringStartsWith(4, $response->getStatusCode());
    }
}
