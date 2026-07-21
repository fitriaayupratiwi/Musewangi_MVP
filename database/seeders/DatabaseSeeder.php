<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'bapak',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'kasir',
            'email' => 'kasir@gmail.com',
            'role' => 'kasir',
            'password' => 'kasir',
        ]);

        $categories = ['Makanan', 'Minuman', 'Camilan'];

        foreach ($categories as $category) {
            Category::create(['nama' => $category]);
        }

        //Menu::factory()->count(10)->create();
    }
}
