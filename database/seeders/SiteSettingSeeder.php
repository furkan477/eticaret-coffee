<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::create([
            'name' => 'Adres',
            'data' => 'MedicalPark AVM içerisinde Kahve Dünyası'
        ]);
        SiteSetting::create([
            'name' => 'phone',
            'data' => '+850 000 00 00'
        ]);
        SiteSetting::create([
            'name' => 'email',
            'data' => 'kahvedunyasi@domain.com'
        ]);
        SiteSetting::create([
            'name' => 'harita',
            'data' => null,
        ]);
    }
}
