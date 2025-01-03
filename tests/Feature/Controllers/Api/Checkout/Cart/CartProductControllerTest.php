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

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function test_add_to_cart_with_no_cart()
    {
        $product = Product::factory()->create();

        $this->actingAs($this->user, 'api')
            ->json('POST', '/api/carts/products/' . $product->id)
            ->assertCreated();

        $cart = $this->user->carts()->where('status', Cart::STATUS_CREATED)->first();

        $this->assertEquals(true, !is_null($cart));
        $this->assertEquals(1, $cart->products()->where('product_id', $product->id)->value('count'));

        $this->json('POST', '/api/carts/products/' . $product->id)
            ->assertCreated();

        $this->assertEquals(1, $cart->products()->where('product_id', $product->id)->count());
    }

    public function test_add_to_cart_with_existing_cart()
    {
        $cart = $this->createCartForUser($this->user);
        $products = Product::factory(2)->create();

        $cart->products()->attach($products[0], ['count' => 2]);

        $this->actingAs($this->user, 'api')
            ->json('POST', '/api/carts/products/' . $products[1]->id)
            ->assertCreated();

        $this->assertEquals(2, $cart->products()->count());
        $this->assertEquals(1, $cart->products()->where('product_id', $products[1]->id)->count());
    }

    /** @test */
    public function test_change_count()
    {
        $cart = $this->createCartForUser($this->user);
        $products = Product::factory(2)->create();

        $cart->products()->attach($products[0], ['count' => 2]);
        $cart->products()->attach($products[1], ['count' => 3]);

        $this->actingAs($this->user, 'api')
            ->json('PATCH', '/api/carts/products/' . $products[1]->id . '/changeCount', [
                'type' => Cart::TYPE_INCREASE
            ])
            ->assertOk();

        $this->assertEquals(2, $cart->products()->where('product_id', $products[0]->id)->value('count'));
        $this->assertEquals(4, $cart->products()->where('product_id', $products[1]->id)->value('count'));

        $this->json('PATCH', '/api/carts/products/' . $products[0]->id . '/changeCount', [
                'type' => Cart::TYPE_DECREASE
            ])
            ->assertOk();

        $this->assertEquals(1, $cart->products()->where('product_id', $products[0]->id)->value('count'));
        $this->assertEquals(4, $cart->products()->where('product_id', $products[1]->id)->value('count'));
    }

    /** @test */
    public function test_remove_product_from_cart()
    {
        $cart = $this->createCartForUser($this->user);
        $products = Product::factory(2)->create();

        $this->actingAs($this->user, 'api')
            ->json('DELETE', '/api/carts/products/' . $products[1]->id)
            ->assertNotFound();

        $cart->products()->attach($products[0], ['count' => 2]);
        $cart->products()->attach($products[1], ['count' => 3]);

        $this->json('DELETE', '/api/carts/products/' . $products[1]->id)
            ->assertOk();

        $this->assertEquals(2, $cart->products()->where('product_id', $products[0]->id)->value('count'));
        $this->assertEquals(false, $cart->products()->where('product_id', $products[1]->id)->exists());
    }

    private function createCartForUser(User $user): Cart
    {
        return Cart::factory()->create([
            'user_id' => $user->id,
            'status'  => Cart::STATUS_CREATED,
        ]);
    }
}
