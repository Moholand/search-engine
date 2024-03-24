<?php

namespace App\Services\Api\Checkout\Cart;

use App\Models\User\Cart;
use App\Repositories\Api\Checkout\CartProductRepository;

class CartProductService
{
    public function __construct(private CartProductRepository $cartProductRepository)
    {}

    public function changeCount(string $type, Cart $cart, int $productId): void
    {
        $this->cartProductRepository->changeCount($type, $cart, $productId);
    }
}
