<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Ybazli\Faker\Facades\Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'گوشی موبایل',
            'لپ تاپ',
            'تبلت'
        ];

        foreach ($categories as $category) {
            $category = Category::create([
                'name' => $category
            ]);

            for ($i=1; $i<=100; $i++) {
                Product::factory()->create([
                    'title' => $category->name . ' ' . str_replace(".", "", Faker::word()),
                    'category_id' => $category->id,
                    'brand_id' => rand(1, Brand::count()),
                    'image' => '/images/products/' . $category->id . rand(1,3) . '.jpg'
                ]);
            }
        }
    }
}
