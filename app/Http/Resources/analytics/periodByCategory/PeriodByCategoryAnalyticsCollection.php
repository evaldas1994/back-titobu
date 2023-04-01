<?php

namespace App\Http\Resources\analytics\periodByCategory;

use App\Services\Service;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Services\analytics\CategoryBalanceService;

class PeriodByCategoryAnalyticsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
