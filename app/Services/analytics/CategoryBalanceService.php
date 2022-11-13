<?php

namespace App\Services\analytics;

use App\Models\Category;
use Carbon\Carbon;

class CategoryBalanceService
{
    public function calculateBalance(Category $category): float
    {
        $transfers = collect();

        $accounts = auth()->user()->accounts;
        foreach ($accounts as $account) {
            $transfers->add($account->transfers
                ->where('category_id', '=', $category->id)
                ->where('created_at', '>', Carbon::now()->firstOfMonth())
                ->where('created_at', '<', Carbon::now()->lastOfMonth())
            );
        }

        return $category->balance - $transfers->collapse()->pluck('amount')->sum();
    }
    public function calculateBalanceDay(Category $category): float
    {
        return $category->balance / Carbon::now()->daysInMonth;
    }
    public function calculateBalanceToday(Category $category): float
    {
        $expected_balance = $category->balance - ($this->calculateBalanceDay($category) * Carbon::now()->day);
        $truth_balance = $this->calculateBalance($category);

        return $truth_balance - $expected_balance;
    }
}
