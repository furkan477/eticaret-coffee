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
    public function definition(): array
    {
        $categoryid = [1,2,3,4,5,6,7,8,9];
        $size = ['S','L','M'];
        $color = ['Siyah','Beyaz','Kahverengi','Sarı','Kırmızı'];

        return [
            'name' => $color[random_int(0,4)].' '.$size[random_int(0,2)].' '.'Urun',
            'category_id' => $categoryid[random_int(0,8)], 
            'short_text' => "Kahve Dünyası",
            'price' => random_int(40,300),
            'size' => $size[random_int(0,2)],
            'color' => $color[random_int(0,4)],
            'qty' => 1,
            'status' => '1',
            'content' => "Kahve Dünyası na Hoşgeldiniz."
        ];
    }
}
