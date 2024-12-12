<?php

namespace Tests\Feature\Requests\Api\Checkout;

use App\Models\Checkout\Cart;
use App\Models\Product;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CartProductRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_change_count_request()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create([
            'user_id' => $user->id,
            'status'  => Cart::STATUS_CREATED
        ]);

        $product = Product::factory()->create();

        $cart->products()->attach($product, ['count' => 2]);

        $this->actingAs($user, 'api')
            ->json('PATCH', '/api/carts/products/' . $product->id . '/changeCount', [
                'type' => ''
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->actingAs($user, 'api')
            ->json('PATCH', '/api/carts/products/' . $product->id . '/changeCount', [
                'type' => 'random-text'
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
