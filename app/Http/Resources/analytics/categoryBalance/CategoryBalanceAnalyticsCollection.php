<?php

namespace App\Http\Resources\analytics\categoryBalance;

use App\Services\Service;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Services\analytics\CategoryBalanceService;

class CategoryBalanceAnalyticsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $service = new Service();

        return [
            'data' => $this->collection,
            'total_balance' => $service->floatFormat((new CategoryBalanceService())->calculateTotalBalance())
        ];
    }
}
