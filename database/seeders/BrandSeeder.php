<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            ['name' => 'Samsung', 'name_farsi' => 'سامسونگ'],
            ['name' => 'Apple', 'name_farsi' => 'اپل'],
            ['name' => 'Lenovo', 'name_farsi' => 'لنوو'],
            ['name' => 'Microsoft', 'name_farsi' => 'مایکروسافت'],
            ['name' => 'Asus', 'name_farsi' => 'ایسوس']
        ];

        foreach ($brands as $brand) {
            Brand::create([
                'name'       => $brand['name'],
                'name_farsi' => $brand['name_farsi']
            ]);
        }
    }
}
