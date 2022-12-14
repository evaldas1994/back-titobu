<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run()
    {
        $names = [
            'Maistas',
            'Mokesčiai',
            'Taupymas',
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
