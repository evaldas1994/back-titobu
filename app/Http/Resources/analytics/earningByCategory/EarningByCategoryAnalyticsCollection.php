<?php

namespace App\Http\Resources\analytics\earningByCategory;

use App\Services\analytics\EarningByCategoryAnalyticsService;
use Illuminate\Http\Resources\Json\ResourceCollection;

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
