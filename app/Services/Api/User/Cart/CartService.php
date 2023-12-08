<?php

namespace App\Services\Api\User\Cart;

use App\Models\User\User;
use App\Repositories\Api\User\CartRepository;

class CartService
{
    public function __construct(private CartRepository $cartRepository)
    {}

    public function itemsCount(User $user): int
    {
        return $this->cartRepository->itemsCount($user);
    }
}
