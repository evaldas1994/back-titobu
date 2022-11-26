<?php

namespace Database\Seeders;

use App\Models\Purpose;
use Illuminate\Database\Seeder;

class PurposeSeeder extends Seeder
{
    public function run()
    {
        $names = [
            'Kasdienis',
            'Sąrašas',
            'Kaupimas'
        ];

        foreach ($names as $name) {
            Purpose::factory()->create(
                [
                    'name' => $name,
                ],
            );
        }
    }
}
