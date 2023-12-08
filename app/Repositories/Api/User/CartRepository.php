<?php

namespace App\Repositories\Api\User;

use App\Models\User\Cart;
use App\Models\User\User;

class CartRepository
{
    public function itemsCount(User $user): int
    {
        $cart = $user->carts()->where('status', Cart::STATUS_CREATED)->first();
        return $cart ? $cart->products()->sum('count') : 0;
    }
}
