<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Espresso', 'price' => rand(15000, 25000)],
            ['name' => 'Cappuccino', 'price' => rand(20000, 30000)],
            ['name' => 'Latte', 'price' => rand(25000, 35000)],
            ['name' => 'Mocha', 'price' => rand(30000, 40000)],
            ['name' => 'Americano', 'price' => rand(20000, 30000)],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create([
                'name' => $product['name'],
                'price' => $product['price'],
                'active' => true,
            ]);
        }
    }
}
