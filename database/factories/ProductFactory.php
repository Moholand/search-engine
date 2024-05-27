<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
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
            'title' => fake()->title(),
            'description' => str_replace(".", "", $this->faker->realText(300)),
            'price' => rand(10, 100) * 1000000,
            'discount' => rand(0, 100),
            'point' => rand(0, 100),
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'image' => fake()->imageUrl()
        ];
    }
}
