<?php

namespace App\Repositories\Api\Checkout;

use App\Models\Checkout\Cart;
use App\Models\User\User;
use Illuminate\Support\Facades\DB;

class CartProductRepository
{
    public function firstOrCreateCart(User $user): Cart
    {
        if ($cart = $this->getCurrentCart($user)) {
            return $cart;
        }

        return $user->carts()->create(['status' => Cart::STATUS_CREATED]);
    }

    public function addProductToCart(Cart $cart, int $productId): void
    {
        if (!$cart->products()->where('product_id', $productId)->exists()) {
            $cart->products()->attach($productId, ['count' => 1]);
        }
    }

    public function changeCount(string $type, Cart $cart, int $productId): void
    {
        $rawExpression = 'count ' . ($type === Cart::TYPE_INCREASE ? '+' : '-') . ' 1';

        $cart->products()->updateExistingPivot($productId, ['count' => DB::raw($rawExpression)]);
    }

    public function getCountOfProductInUserCart(User $user, int $productId): int
    {
        if ($cart = $this->getCurrentCart($user)) {
            return $cart->products()->where('product_id', $productId)->value('count') ?? 0;
        }
        return 0;
    }

    public function removeProductFromCart(Cart $cart, int $productId): void
    {
        $cart->products()->detach($productId);
    }

    public function getCurrentCart(User $user): ?Cart
    {
        return $user->carts()->where('status', Cart::STATUS_CREATED)->first();
    }
}
