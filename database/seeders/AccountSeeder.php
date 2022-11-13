<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run()
    {
        $names = [
            'E Banko sąskaita',
            'E Gryni pinigai',
            'G Banko sąskaita',
            'G Gryni pinigai',
            'Tadas',
            'Taupymas',
            'Rezervas',
        ];

        foreach ($names as $name) {
            Account::factory()->create(
                [
                    'name' => $name,
                ],
            );
        }
    }
}
