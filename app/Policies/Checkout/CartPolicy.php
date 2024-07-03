<?php

namespace App\Policies\Checkout;

use App\Models\Checkout\Cart;
use App\Models\Product;
use App\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CartPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Cart $cart, Product $product): bool
    {
        return $user->id == $cart->user_id
            && in_array($product->id, $cart->products->pluck('id')->toArray());
    }
}
