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
     * @param int $count
     * @return \Illuminate\Support\Collection|Category
     */
    public function createCategory(int $count = 1): mixed
    {
        if ($count === 1) {
            return Category::create(['name' => 'test category']);
        }

        $categories = [];
        for ($i = 0; $i < $count; $i++) {
            $categories[] = Category::create(['name' => 'test category' . $i]);
        }
        return collect($categories);
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
