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
        return [
            'total' => Category::all()->pluck('savings')->sum(),
            'total_earnings' => (new EarningByCategoryAnalyticsService())->getTotalOfThisPeriod(),
            'total_expenses' => (new ExpenseByCategoryAnalyticsService())->getTotalOfThisPeriod(),
            'data' => $this->collection,
        ];
    }
}
