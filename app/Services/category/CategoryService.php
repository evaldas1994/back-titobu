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
        $account = $this->getAccount($validated);

        return $account->categories()->create($validated);
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

    private function getAccount($validated): Account
    {
        if (!Arr::exists($validated, 'account_id'))
            return Account::create($validated);
        else
            return Account::find(Arr::get($validated, 'account_id'));
    }
}
