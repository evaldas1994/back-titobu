<?php

namespace App\Http\Resources\analytics\expenseByCategory;

use App\Services\analytics\EarningByCategoryAnalyticsService;
use App\Services\analytics\ExpenseByCategoryAnalyticsService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ExpenseByCategoryAnalyticsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'total' => 0,
            'total_earnings' => (new EarningByCategoryAnalyticsService())->getTotalOfThisPeriod(),
            'total_expenses' => (new ExpenseByCategoryAnalyticsService())->getTotalOfThisPeriod(),
            'data' => $this->collection,
        ];
    }
}
