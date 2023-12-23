<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Traits\Test\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, ProductFactory;

    /** @test */
    public function a_user_can_see_list_of_categories()
    {
        $categories = $this->createCategory(3);

        foreach ($categories as $category) {
            $this->createProduct($category->id);
        }

        $response = $this->get('/api/categories')->assertOk()->assertJsonStructure([
            '*' => ['id', 'name', 'image']
        ]);

        $responseCollections = $categories->map(function (Category $category) {
            return [
                'id'    => $category['id'],
                'name'  => $category['name'],
                'image' => Product::query()->where('category_id', $category['id'])->first()?->image
            ];
        });

        // Each category in the response must have the correct image attribute
        $response->assertJson($responseCollections->toArray());
    }
}
