<?php

namespace Tests\Feature\Controllers\Api\Product;

use App\Models\Checkout\Cart;
use App\Models\Product;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_count_of_product_in_user_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        // UnAuthenticated User
        $this->json('GET', '/api/products/' . $product->id)
            ->assertOk()
            ->assertJson([
                'count_in_user_cart' => 0,
            ]);

        $this->actingAs($user, 'api')
            ->json('GET', '/api/products/' . $product->id)
            ->assertOk()
            ->assertJson([
                'count_in_user_cart' => 0,
            ]);

        $cart = Cart::factory()->create([
            'user_id' => $user->id,
            'status'  => Cart::STATUS_CREATED
        ]);

        $cart->products()->attach($product->id, ['count' => 3]);

        $this->actingAs($user, 'api')
            ->json('GET', '/api/products/' . $product->id)
            ->assertOk()
            ->assertJson([
                'count_in_user_cart' => 3,
            ]);
    }
}
