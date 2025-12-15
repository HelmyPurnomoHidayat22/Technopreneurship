<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Categories
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);

        // Create Admin User
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@digitalcreativehub.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Test User (optional)
        \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'user@digitalcreativehub.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
