<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'name' => 'SUPER ADMIN',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password')
        ]);

        User::factory()->create([
            'name' => 'Evaldas Tuleikis',
            'email' => 'evaldas.tuleikis@gmail.com',
            'password' => Hash::make('password')
        ]);
    }
}
