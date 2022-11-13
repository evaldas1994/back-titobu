<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Mokesčiai',
                'balance' => 600.00,
                'type' => Category::TYPE_OUT,
            ],
            [
                'name' => 'Maistas',
                'balance' => 240.00,
                'type' => Category::TYPE_OUT,
            ],
            [
                'name' => 'Transportas',
                'balance' => 140.00,
                'type' => Category::TYPE_OUT,
            ],
            [
                'name' => 'Švara',
                'balance' => 60.00,
                'type' => Category::TYPE_OUT,
            ],
            [
                'name' => 'Tadas',
                'balance' => 80.00,
                'type' => Category::TYPE_OUT,
            ],
            [
                'name' => 'Taupymas',
                'balance' => 100.00,
                'type' => Category::TYPE_OUT,
            ],
            [
                'name' => 'UAB Dineta',
                'balance' => 0,
                'type' => Category::TYPE_IN,
            ],
        ];



        foreach ($data as $item) {
            Category::factory()->create($item);
        }
    }
}
