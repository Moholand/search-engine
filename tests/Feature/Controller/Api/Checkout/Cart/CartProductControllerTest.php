<?php

namespace Tests\Feature\Controller\Api\Checkout\Cart;

use App\Models\Checkout\Cart;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_see_list_of_categories()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create([
            'user_id' => $user->id,
            'status'  => 'created'
        ]);


    }
}
