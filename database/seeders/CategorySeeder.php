<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kahve = Category::create([
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => null,
            'name' => 'Kahve',
            'content' => 'Dünyası',
            'status' => '1',
        ]);
        Category::create([
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => $kahve->id,
            'name' => 'Kahve ve Çay',
            'content' => 'Dünyası',
            'status' => '1',  
        ]);
        Category::create([
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => $kahve->id,
            'name' => 'Kahve ve Sahlep',
            'content' => 'Dünyası',
            'status' => '1',
        ]);

        $pasta = Category::create([
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => null,
            'name' => 'Pasta',
            'content' => 'Dünyası',
            'status' => '1',
        ]);
        Category::create([
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => $pasta->id,
            'name' => 'Pasta ve Tatlı',
            'content' => 'Dünyası',
            'status' => '1',
        ]);
        Category::create([
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => $pasta->id,
            'name' => 'Pasta ve Kek',
            'content' => 'Dünyası',
            'status' => '1',
        ]);

        $sekerleme = Category::create([
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => null,
            'name' => 'Şekerleme',
            'content' => 'Dünyası',
            'status' => '1',
        ]);
        Category::create([
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => $sekerleme->id,
            'name' => 'Şekerleme ve lokum',
            'content' => 'Dünyası',
            'status' => '1',
        ]);
        Category::create([
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => $sekerleme->id,
            'name' => 'Şekerleme ve Çikolata',
            'content' => 'Dünyası',
            'status' => '1',
        ]);
    }
}
