<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Super Admin Musewangi
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator Musewangi',
                'username' => 'admin',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Petugas / Kasir
        User::updateOrCreate(
            ['email' => 'kasir@gmail.com'],
            [
                'name' => 'Petugas Loket',
                'username' => 'petugas',
                'role' => 'kasir',
                'password' => Hash::make('petugas123'),
                'email_verified_at' => now(),
            ]
        );

        // 3. Kategori Kuratorial Museum
        $categories = [
            'Arkeologi',
            'Etnografi',
            'Numismatika & Heraldika',
            'Filologi',
            'Keramologi',
            'Seni Rupa & Kriya',
            'Teknologi Tradisional',
            'Geologi'
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['nama' => $category]);
        }
    }
}
