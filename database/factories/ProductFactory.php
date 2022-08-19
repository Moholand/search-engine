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
            'title' => 'گوشی ' . str_replace(".", "", $this->faker->realText(20)),
            'description' => str_replace(".", "", $this->faker->realText(300)),
            'price' => 1200000,
            'discount' => 0,
            'category_id' => 1,
            'point' => 50
        ];
    }
}
