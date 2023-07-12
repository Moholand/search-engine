<?php

namespace Tests\Feature;

use App\Traits\Test\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase, ProductFactory;

    /** @test */
    public function a_user_can_search_for_products()
    {
        $this->createProduct();

        // Make a search request
        $response = $this->json('GET', '/api/products/search', ['page' => 1])->assertOk();

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

    /** @test */
    public function a_user_can_see_product_details()
    {
        $product = $this->createProduct();

        $response = $this->json('GET', '/api/products/' . $product->id)->assertOk();

        // Assert that the response contains the expected JSON data
        $response->assertJson([
            'id'    => $product->id,
            'title' => $product->title,
            'image' => $product->image,
            'point' => $product->point,
            'price' => $product->price,
        ]);
    }
}
