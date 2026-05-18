<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Antibiotics',       'icon' => 'bi-shield-plus',       'description' => 'Medicines that fight bacterial infections'],
            ['name' => 'Vitamins',          'icon' => 'bi-sun',               'description' => 'Dietary supplements and vitamins'],
            ['name' => 'Pain Relief',       'icon' => 'bi-thermometer',       'description' => 'Analgesics and pain management medicines'],
            ['name' => 'Diabetes Care',     'icon' => 'bi-droplet',           'description' => 'Medicines for diabetes management'],
            ['name' => 'Heart Care',        'icon' => 'bi-heart-pulse',       'description' => 'Cardiovascular medicines'],
            ['name' => 'Skin Care',         'icon' => 'bi-person',            'description' => 'Dermatological medicines and creams'],
            ['name' => 'Digestive Health',  'icon' => 'bi-activity',          'description' => 'Medicines for digestive problems'],
            ['name' => 'Cold & Cough',      'icon' => 'bi-wind',              'description' => 'Medicines for cold, cough and fever'],
            ['name' => 'Eye & Ear Care',    'icon' => 'bi-eye',               'description' => 'Ophthalmic and ear drops'],
            ['name' => 'First Aid',         'icon' => 'bi-bandaid',           'description' => 'First aid and wound care products'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name'        => $cat['name'],
                'slug'        => Str::slug($cat['name']),
                'description' => $cat['description'],
                'icon'        => $cat['icon'],
                'is_active'   => true,
            ]);
        }
    }
}