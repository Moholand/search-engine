<?php

namespace App\Repositories\Api\Checkout;

use App\Models\User\Cart;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Collection;

class CartRepository
{
    public function index(User $user): Collection
    {
        $cart = $user->carts()->with('products')
            ->where('status', Cart::STATUS_CREATED)->first();

        return $cart?->products;
    }

    public function itemsCount(User $user): int
    {
        return $user->carts()
            ->where('status', Cart::STATUS_CREATED)
            ->withCount('products')
            ->value('products_count') ?? 0;
    }
}
