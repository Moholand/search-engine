<?php

namespace Database\Factories\Checkout;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $statusArray = ['created', 'paid'];

        return [
            'user_id' => User::factory(),
            'status'  => $statusArray[rand(0, 1)],
        ];
    }
}
