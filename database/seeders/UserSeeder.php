<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name'      => 'Super Admin',
            'email'     => 'admin@medplus.com',
            'phone'     => '9999999999',
            'password'  => Hash::make('Admin@1234'),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        // Create Pharmacist
        User::create([
            'name'      => 'angel Pharmacist',
            'email'     => 'pharmacist@medplus.com',
            'phone'     => '8888888888',
            'password'  => Hash::make('Pharma@1234'),
            'role'      => 'pharmacist',
            'is_active' => true,
        ]);

        // Create Sample Customer
        User::create([
            'name'      => 'hery mugalama',
            'email'     => 'customer@medplus.com',
            'phone'     => '7777777777',
            'password'  => Hash::make('Customer@1234'),
            'role'      => 'customer',
            'is_active' => true,
        ]);
    }
}