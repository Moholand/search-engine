<?php

namespace Tests\Feature\User;

use App\Models\User\Cart;
use App\Traits\Test\ProductFactory;
use App\Traits\Test\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase, UserFactory, ProductFactory;

    /** @test */
    public function correctItemsCountWillBeReturns()
    {
        $this->withoutExceptionHandling();
        $user = $this->createUser();

        $cart = Cart::create([
            'user_id' => $user->id,
            'status'  => Cart::STATUS_CREATED,
        ]);

        $cart->products()->attach($this->createProduct()->id, ['count' => 2]);
        $cart->products()->attach($this->createProduct()->id, ['count' => 4]);

        $this->actingAs($user, 'api')->json('GET', '/api/carts/items-count')->assertOk()
            ->assertJson(['items_count' => 6]);
    }
}
