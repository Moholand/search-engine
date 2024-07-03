<?php

namespace Tests\Feature\Policies\Checkout;

use App\Models\Checkout\Cart;
use App\Models\Product;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_cart_update_policy()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();

        $cart = Cart::factory()->create([
            'user_id' => $user->id,
            'status'  => Cart::STATUS_CREATED
        ]);

        $products = Product::factory(2)->create();

        $cart->products()->attach($products[0], ['count' => 2]);

        $this->actingAs($anotherUser, 'api')
            ->json('PATCH', '/api/carts/' . $cart->id . '/products/' . $products[0]->id . '/changeCount', [
                'type' => Cart::TYPE_INCREASE
            ])
            ->assertForbidden();

        $this->actingAs($user, 'api')
            ->json('PATCH', '/api/carts/' . $cart->id . '/products/' . $products[1]->id . '/changeCount', [
                'type' => Cart::TYPE_INCREASE
            ])
            ->assertForbidden();
    }
}
