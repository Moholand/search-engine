<?php

namespace Tests\Unit;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_product_belongs_to_a_category()
    {
        $category = $this->createCategory();

        $brand = $this->createBrand();

        $product = $this->createProduct($category->id, $brand->id);

        $this->assertInstanceOf(Category::class, $product->category);
        $this->assertEquals($category->id, $product->category->id);
    }

    /** @test */
    public function a_product_belongs_to_a_brand()
    {
        $category = $this->createCategory();

        $brand = $this->createBrand();

        $product = $this->createProduct($category->id, $brand->id);

        $this->assertInstanceOf(Brand::class, $product->brand);
        $this->assertEquals($brand->id, $product->brand->id);
    }

    private function createCategory(): Category
    {
        return Category::create([
            'name' => 'test category'
        ]);
    }

    private function createBrand(): Brand
    {
        return Brand::create([
            'name' => 'test category',
            'name_farsi' => 'تست'
        ]);
    }

    private function createProduct(int $categoryId, int $brandId): Product
    {
        return Product::create([
            'title' => 'test',
            'description' => 'test description',
            'price' => 56000000,
            'discount' => 75,
            'category_id' => $categoryId,
            'brand_id' => $brandId,
            'point' => 10,
            'image' => '/images/products/13.jpg'
        ]);
    }
}
