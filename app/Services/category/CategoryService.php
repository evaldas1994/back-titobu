<?php

namespace App\Services\category;

use Illuminate\Support\Arr;
use App\Services\Service;
use App\Models\Category;
use App\Models\Account;

class CategoryService extends Service
{
    public function store(array $validated)
    {
        return Category::create($validated);
    }

    public function update(Category $category, array $validated): Category
    {
        $category->update($validated);

        return $category;
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }
}
