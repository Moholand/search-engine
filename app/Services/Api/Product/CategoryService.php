<?php

namespace App\Services\Api\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    /**
     * @return Collection
     */
    public function index(): Collection
    {
        $categories = Category::select('id', 'name')->get();

        foreach ($categories as $category) {
            $category->image = Product::where('category_id', $category->id)->first()?->image;
        }

        return $categories;
    }
}
