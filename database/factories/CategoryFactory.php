<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    public function definition()
    {
        $user_id = User::first()->id;

        return [
            'name' => fake()->words(2, true),
            'balance' => fake()->randomFloat(2,100,300),
            'type' => Arr::random(Category::getTypes()),
            'account_id' => Arr::random(Account::all()->pluck('id')->toArray()),
            'user_id' => $user_id,
        ];
    }
}
