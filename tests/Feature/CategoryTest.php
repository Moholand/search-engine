<?php

namespace Tests\Feature;

use App\Traits\Test\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, ProductFactory;

    /** @test */
    public function a_user_can_see_list_of_categories()
    {
        $categories = $this->createCategory(3);

        foreach ($categories as $category) {
            $product = $this->createProduct($category->id);
        }

        $response = $this->get('/api/categories')->assertOk();

        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'image',
            ],
        ]);

        // Todo: Assert that each category in the response has the correct image attribute
    }
}
