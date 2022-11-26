<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Maistas',
                'balance' => 120.00,
                'type' => Category::TYPE_OUT,
                'purpose_id' => 1,
                'account_id' => 1
            ],
            [
                'name' => 'Mokesčiai',
                'balance' => 520.00,
                'type' => Category::TYPE_OUT,
                'purpose_id' => 2,
                'account_id' => 2
            ],
            [
                'name' => 'Taupymas',
                'balance' => 250.00,
                'type' => Category::TYPE_OUT,
                'purpose_id' => 3,
                'account_id' => 3
            ]
        ];



        foreach ($data as $item) {
            Category::factory()->create($item);
        }
    }
}
