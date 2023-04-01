<?php

namespace App\Http\Resources\analytics\earningByCategory;

use App\Services\analytics\EarningByCategoryAnalyticsService;
use App\Services\Service;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Services\analytics\CategoryBalanceService;

class EarningByCategoryAnalyticsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'total' => (new EarningByCategoryAnalyticsService())->getTotalOfThisPeriod(),
            'data' => $this->collection,
        ];
    }
}
