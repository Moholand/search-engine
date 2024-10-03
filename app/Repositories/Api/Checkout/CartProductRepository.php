<?php

namespace App\Repositories\Api\Checkout;

use App\Models\Checkout\Cart;
use App\Models\User\User;
use Illuminate\Support\Facades\DB;

class CartProductRepository
{
    public function getOrCreateCart(User $user): Cart
    {
        if ($cart = $user->carts()->where('status', Cart::STATUS_CREATED)->first()) {
            return $cart;
        }

        return $user->carts()->create(['status' => Cart::STATUS_CREATED]);
    }

    public function addProductToCart(Cart $cart, int $productId): void
    {
        $cart->products()->attach($productId, ['count' => 1]);
    }

    public function changeCount(string $type, Cart $cart, int $productId): void
    {
        $rawExpression = 'count ' . ($type === Cart::TYPE_INCREASE ? '+' : '-') . ' 1';

        $cart->products()->updateExistingPivot($productId, ['count' => DB::raw($rawExpression)]);
    }
}
