<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Slider::create([
            'image' => 'https://fakeimg.pl/250x100/',
            'name' => 'Kahve Dünyası',
            'content' => '100 den fazla çeşit çeşit kahvelerimizi deneyiniz yanında şekerleme ile beraber',
            'link' => 'urunler',
            'status' => '1'
        ]);
    }
}
