<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            "name" => 'Kahve Latte',
            "image" => 'images/cloth_1.jpg',
            "category_id" => 1,
            "short_text" => 'Kahve Dünyası',
            "price" => 85,
            "size" => 'orta',
            "color" => 'siyah',
            "qty" => 2,
            "status" => '1',
            "content" => 'Kahve Dünyası na Hoşgeldiniz.'
        ]);
        Product::create([
            "name" => 'Kahve Mocha',
            "image" => 'images/shoe_1.jpg',
            "category_id" => 2,
            "short_text" => 'Kahve Dünyası',
            "price" => 125,
            "size" => 'büyük',
            "color" => 'beyaz',
            "qty" => 5,
            "status" => '1',
            "content" => 'Kahve Dünyası na Hoşgeldiniz.'
        ]);
    }
}
