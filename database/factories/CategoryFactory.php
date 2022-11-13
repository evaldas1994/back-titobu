<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => fake()->words(2, true),
            'balance' => fake()->randomFloat(2,100,300),
            'type' => Arr::random(Category::getTypes()),
        ];
    }
}
