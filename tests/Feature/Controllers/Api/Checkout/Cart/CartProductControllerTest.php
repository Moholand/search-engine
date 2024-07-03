<?php

namespace Tests\Feature\Controllers\Api\Checkout\Cart;

use App\Models\Checkout\Cart;
use App\Models\Product;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_change_count()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create([
            'user_id' => $user->id,
            'status'  => Cart::STATUS_CREATED
        ]);

        $products = Product::factory(2)->create();

        $cart->products()->attach($products[0], ['count' => 2]);
        $cart->products()->attach($products[1], ['count' => 3]);

        $this->actingAs($user, 'api')
            ->json('PATCH', '/api/carts/' . $cart->id . '/products/' . $products[1]->id . '/changeCount', [
                'type' => Cart::TYPE_INCREASE
            ])
            ->assertOk();

        $this->assertEquals(2, $cart->products()->where('product_id', $products[0]->id)->value('count'));
        $this->assertEquals(4, $cart->products()->where('product_id', $products[1]->id)->value('count'));

        $this->actingAs($user, 'api')
            ->json('PATCH', '/api/carts/' . $cart->id . '/products/' . $products[0]->id . '/changeCount', [
                'type' => Cart::TYPE_DECREASE
            ])
            ->assertOk();

        $this->assertEquals(1, $cart->products()->where('product_id', $products[0]->id)->value('count'));
        $this->assertEquals(4, $cart->products()->where('product_id', $products[1]->id)->value('count'));
    }
}
