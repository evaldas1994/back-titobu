<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
//            PurposeSeeder::class,
//            AccountSeeder::class,
//            CategorySeeder::class,
//            TransferSeeder::class,
        ]);
    }
}
