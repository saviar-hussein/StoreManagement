<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

    // // 1. Create Admin
    // User::create([
    //     'name' => 'rozha Admin',
    //     'email' => 'admin@store.com',
    //     'password' => Hash::make('password123'), // BCrypt hashing
    //     'role' => 'admin',
    // ]);

    // // 2. Create Cashier
    // User::create([
    //     'name' => 'rozha Cashier',
    //     'email' => 'cashier@store.com',
    //     'password' => Hash::make('password123'),
    //     'role' => 'cashier',
    // ]);

    //     User::create([
    //     'name' => 'shakar',
    //     'email' => 'shakar@store.com',
    //     'password' => Hash::make('password123'),
    //     'role' => 'cashier',
    // ]);
    }
}
