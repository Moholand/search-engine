<?php

namespace App\Traits\Test;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

trait ProductFactory
{
    /**
     * @param int|null $categoryId
     * @param int|null $brandId
     * @return Product
     */
    public function createProduct(?int $categoryId = null, ?int $brandId = null): Product
    {
        return Product::create([
            'title' => 'test',
            'description' => 'test description',
            'price' => 56000000,
            'discount' => 75,
            'category_id' => $categoryId ?? $this->createCategory()->id,
            'brand_id' => $brandId ?? $this->createBrand()->id,
            'point' => 10,
            'image' => '/images/products/13.jpg'
        ]);
    }

    /**
     * @return Category
     */
    public function createCategory(): Category
    {
        return Category::create([
            'name' => 'test category'
        ]);
    }

    /**
     * @return Brand
     */
    public function createBrand(): Brand
    {
        return Brand::create([
            'name' => 'test category',
            'name_farsi' => 'تست'
        ]);
    }
}
