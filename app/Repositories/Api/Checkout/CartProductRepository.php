<?php

namespace App\Repositories\Api\Checkout;

use App\Models\User\Cart;
use Illuminate\Support\Facades\DB;

class CartProductRepository
{
    public function changeCount(string $type, Cart $cart, int $productId): void
    {
        $rawExpression = 'count ' . ($type === Cart::TYPE_INCREASE ? '+' : '-') . ' 1';

        $cart->products()->updateExistingPivot($productId, ['count' => DB::raw($rawExpression)]);
    }
}
