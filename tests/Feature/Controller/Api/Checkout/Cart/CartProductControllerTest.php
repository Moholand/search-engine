<?php

namespace Tests\Feature\Controller\Api\Checkout\Cart;

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
            'status'  => 'created'
        ]);

        $productA = Product::factory()->create();
        $productB = Product::factory()->create();

        $cart->products()->attach($productA, ['count' => 2]);
        $cart->products()->attach($productB, ['count' => 3]);

        $this->actingAs($user, 'api')
            ->json('PATCH', '/api/carts/' . $cart->id . '/products/' . $productB->id . '/changeCount', [
                'type' => Cart::TYPE_INCREASE
            ])
            ->assertOk();

        $this->assertEquals(2, $cart->products()->where('product_id', $productA->id)->value('count'));
        $this->assertEquals(4, $cart->products()->where('product_id', $productB->id)->value('count'));

        $this->actingAs($user, 'api')
            ->json('PATCH', '/api/carts/' . $cart->id . '/products/' . $productA->id . '/changeCount', [
                'type' => Cart::TYPE_DECREASE
            ])
            ->assertOk();

        $this->assertEquals(1, $cart->products()->where('product_id', $productA->id)->value('count'));
        $this->assertEquals(4, $cart->products()->where('product_id', $productB->id)->value('count'));
    }
}
