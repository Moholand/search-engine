<?php

namespace Tests\Unit;

use App\Models\Brand;
use App\Models\Category;
use App\Traits\Test\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase, ProductFactory;

    /** @test */
    public function a_product_belongs_to_a_category()
    {
        $category = $this->createCategory();
        $product = $this->createProduct($category->id, null);

        $this->assertInstanceOf(Category::class, $product->category);
        $this->assertEquals($category->id, $product->category->id);
    }

    /** @test */
    public function a_product_belongs_to_a_brand()
    {
        $brand = $this->createBrand();
        $product = $this->createProduct(null, $brand->id);

        $this->assertInstanceOf(Brand::class, $product->brand);
        $this->assertEquals($brand->id, $product->brand->id);
    }
}
