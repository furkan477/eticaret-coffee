<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        About::create([
            'name' => 'Kahve Dünyası Hakkında',
            'content' => 'Kahve, kökboyasıgiller familyasının Coffea cinsinde yer alan bir ağaç ve bu ağacın meyve çekirdeklerinin kavrulup öğütülmesi ile elde edilen tozun su ya da süt ile karıştırılmasıyla yapılan içecektir.',
            'text_1_icon' => 'icon-truck',
            'text_1_content' => 'Kahvelerinizi ve yanında en iyi giden atıştırmalık kekleri ve pastaları sıcak sıcak getiriyoruz.',
            'text_1' => 'Ücretsiz Getirme',
            'text_2_icon' => 'icon-refresh2',
            'text_2_content' => 'Ürünlerimizde bir tat bozukluğu ve bozulma durumunda geri aide alıyoruz.',
            'text_2' => 'Geri İade',
            'text_3_icon' => 'icon-help',
            'text_3_content' => '7/24 destek sayfamız ile sorunlarınızı çözmenize yardımcı olabiliriz.',
            'text_3' => 'Destek Sayfası',
        ]);
    }
}
