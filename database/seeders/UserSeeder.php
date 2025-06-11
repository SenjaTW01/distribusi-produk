<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'active' => true,
        ]);

        \App\Models\User::create([
            'name' => 'Barista',
            'email' => 'barista@example.com',
            'password' => bcrypt('password'),
            'active' => true,
        ]);
    }
}
