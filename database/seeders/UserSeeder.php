<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
     
        User::create([
            'name' => 'Admin Principal',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'reputation' => 100,
            'banned_at' => null,
        ]);

      
        User::factory()->count(20)->create();
    }
}
