<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'description' => str_replace(".", "", $this->faker->realText(300)),
            'price' => rand(10, 100) * 1000000,
            'discount' => rand(0, 100),
            'point' => rand(0, 100)
        ];
    }
}
