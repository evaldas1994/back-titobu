<?php

namespace App\Http\Resources\analytics\analyticByCategory;

use App\Models\Category;
use App\Services\analytics\EarningByCategoryAnalyticsService;
use App\Services\analytics\ExpenseByCategoryAnalyticsService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AnalyticByCategoryAnalyticsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $savingsOfExpenses = Category::where('type', 'expenses')->pluck('savings')->sum();
        $savingsOfSavings = Category::where('type', 'savings')->pluck('savings')->sum();
        $totalEarnings = (new EarningByCategoryAnalyticsService())->getTotalOfThisPeriod();
        $totalExpenses = (new ExpenseByCategoryAnalyticsService())->getTotalOfThisPeriod();

        $total = $savingsOfExpenses + ($totalEarnings - $totalExpenses) + $savingsOfSavings;

        return [
            'total' => $total,
            'total_earnings' => $totalEarnings,
            'total_expenses' => $totalExpenses,
            'total_savings' => $savingsOfSavings,
            'data' => $this->collection,
        ];
    }
}
