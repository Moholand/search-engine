<?php

namespace App\Services\Api\Product;

use App\Models\Product;
use App\Repositories\Api\Checkout\CartProductRepository;

class ProductService
{
    public function show(Product $product): Product
    {
        if ($user = request()->user('api')) {
            $cartProductRepository = resolve(CartProductRepository::class);
            $countInUserCart = $cartProductRepository->getCountOfProductInUserCart($user, $product->id);
        }
        
        $product->setAttribute('count_in_user_cart', $countInUserCart ?? 0);

        return $product;
    }
}
