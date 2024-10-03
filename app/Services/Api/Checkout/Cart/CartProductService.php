<?php

namespace App\Services\Api\Checkout\Cart;

use App\Models\Checkout\Cart;
use App\Models\Product;
use App\Repositories\Api\Checkout\CartProductRepository;

class CartProductService
{
    public function __construct(private CartProductRepository $cartProductRepository)
    {}

    public function addToCart(Product $product): void
    {
        $cart = $this->cartProductRepository->getOrCreateCart(request()->user('api'));
        
        $this->cartProductRepository->addProductToCart($cart, $product->id);
    }

    public function changeCount(string $type, Cart $cart, int $productId): void
    {
        $this->cartProductRepository->changeCount($type, $cart, $productId);
    }
}
