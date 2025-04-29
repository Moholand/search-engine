<?php

namespace App\Repositories\Api\Checkout;

use App\Models\Checkout\Cart;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CartRepository
{
    public function index(User $user): Collection
    {
        $cart = $user->carts()->with('products')
            ->where('status', Cart::STATUS_CREATED)->first();

        return $cart?->products;
    }

    public function itemsCount(int $userId): int
    {
        return DB::table('rel_cart_product')
            ->join('carts', 'carts.id', '=', 'rel_cart_product.cart_id')
            ->where('carts.id', $userId)
            ->where('carts.status', Cart::STATUS_CREATED)
            ->sum('rel_cart_product.count');
    }
}
