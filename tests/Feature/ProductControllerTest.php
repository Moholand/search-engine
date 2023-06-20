<?php

namespace Tests\Feature;

use App\Traits\Test\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase, ProductFactory;

    public function test_product_search()
    {
        $this->createProduct();

        // Make a search request
        $response = $this->json('GET', '/api/products/search', [
            'page' => 1
        ]);

        // Assert that the response has a successful status code
        $response->assertStatus(200);

        // Assert that the response contains the expected data
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'image',
                    'point',
                    'price',
                    'title',
                    '_score'
                ]
            ]
        ]);
    }
}
