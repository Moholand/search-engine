<?php

namespace App\Services\Api\Product;

use App\Models\Product;

class ProductService
{
    public function show(Product $product): Product
    {
        request()->user('api');
        $product->setAttribute('count_in_cart', 5);

        return $product;
    }
}
