<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        $antibiotic    = Category::where('name', 'Antibiotics')->first();
        $vitamin       = Category::where('name', 'Vitamins')->first();
        $painRelief    = Category::where('name', 'Pain Relief')->first();
        $coldCough     = Category::where('name', 'Cold & Cough')->first();
        $diabetes      = Category::where('name', 'Diabetes Care')->first();

        $medicines = [
            [
                'category_id'           => $antibiotic->id,
                'name'                  => 'Amoxicillin 500mg',
                'brand'                 => 'Novamox',
                'generic_name'          => 'Amoxicillin Trihydrate',
                'description'           => 'Broad-spectrum antibiotic used to treat bacterial infections.',
                'price'                 => 85.00,
                'cost_price'            => 60.00,
                'discount'              => 5,
                'stock'                 => 150,
                'min_stock_alert'       => 20,
                'dosage'                => '500mg',
                'form'                  => 'capsule',
                'expiry_date'           => now()->addYears(2),
                'requires_prescription' => true,
                'is_active'             => true,
            ],
            [
                'category_id'           => $painRelief->id,
                'name'                  => 'Paracetamol 650mg',
                'brand'                 => 'Crocin',
                'generic_name'          => 'Acetaminophen',
                'description'           => 'Used for mild to moderate pain and fever reduction.',
                'price'                 => 22.50,
                'cost_price'            => 12.00,
                'discount'              => 0,
                'stock'                 => 500,
                'min_stock_alert'       => 50,
                'dosage'                => '650mg',
                'form'                  => 'tablet',
                'expiry_date'           => now()->addYears(3),
                'requires_prescription' => false,
                'is_active'             => true,
            ],
            [
                'category_id'           => $vitamin->id,
                'name'                  => 'Vitamin C 1000mg',
                'brand'                 => 'Limcee',
                'generic_name'          => 'Ascorbic Acid',
                'description'           => 'Boosts immunity and acts as antioxidant.',
                'price'                 => 45.00,
                'cost_price'            => 28.00,
                'discount'              => 10,
                'stock'                 => 300,
                'min_stock_alert'       => 30,
                'dosage'                => '1000mg',
                'form'                  => 'tablet',
                'expiry_date'           => now()->addYears(2),
                'requires_prescription' => false,
                'is_active'             => true,
            ],
            [
                'category_id'           => $coldCough->id,
                'name'                  => 'Cetirizine 10mg',
                'brand'                 => 'Zyrtec',
                'generic_name'          => 'Cetirizine Hydrochloride',
                'description'           => 'Antihistamine for allergy, cold and runny nose.',
                'price'                 => 35.00,
                'cost_price'            => 20.00,
                'discount'              => 0,
                'stock'                 => 8,  // intentionally low for demo
                'min_stock_alert'       => 15,
                'dosage'                => '10mg',
                'form'                  => 'tablet',
                'expiry_date'           => now()->addYears(1),
                'requires_prescription' => false,
                'is_active'             => true,
            ],
            [
                'category_id'           => $diabetes->id,
                'name'                  => 'Metformin 500mg',
                'brand'                 => 'Glycomet',
                'generic_name'          => 'Metformin Hydrochloride',
                'description'           => 'Oral antidiabetic medicine for Type 2 diabetes.',
                'price'                 => 55.00,
                'cost_price'            => 32.00,
                'discount'              => 0,
                'stock'                 => 200,
                'min_stock_alert'       => 25,
                'dosage'                => '500mg',
                'form'                  => 'tablet',
                'expiry_date'           => now()->addYears(2),
                'requires_prescription' => true,
                'is_active'             => true,
            ],
        ];

        foreach ($medicines as $med) {
            Medicine::create(array_merge($med, [
                'slug' => Str::slug($med['name']) . '-' . uniqid(),
            ]));
        }
    }
}