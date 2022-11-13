<?php

namespace Database\Seeders;

use App\Models\Transfer;
use Illuminate\Database\Seeder;

class TransferSeeder extends Seeder
{
    public function run()
    {
        Transfer::factory(1000)->create();
    }
}
