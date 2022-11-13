<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use App\Models\Category;
use App\Models\Account;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transfer>
 */
class TransferFactory extends Factory
{
    public function definition()
    {
        $user_id = User::first()->id;
        $category_ids = Category::all()->pluck('id')->toArray();
        $account_ids = Account::where('user_id', '=', $user_id)->pluck('id')->toArray();

        return [
            'name' => fake()->words(2, true),
            'amount' => fake()->randomFloat(2,0.01,100),
            'category_id' => Arr::random($category_ids),
            'account_id' => Arr::random($account_ids),
        ];
    }
}
