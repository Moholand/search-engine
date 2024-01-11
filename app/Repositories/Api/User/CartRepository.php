<?php

namespace App\Repositories\Api\User;

use App\Models\User\Cart;
use App\Models\User\User;

class CartRepository
{
    public function index(User $user)
    {
        $cart = $user->carts()->with('products')
            ->where('status', Cart::STATUS_CREATED)->first();
        return $cart?->pluck('products');
    }

    public function itemsCount(User $user): int
    {
        $cart = $user->carts()->where('status', Cart::STATUS_CREATED)->first();
        return $cart ? $cart->products()->sum('count') : 0;
    }
}
