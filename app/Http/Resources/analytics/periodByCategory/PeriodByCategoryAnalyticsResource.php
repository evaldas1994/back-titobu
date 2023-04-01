<?php

namespace App\Http\Resources\analytics\periodByCategory;

use App\Http\Resources\BaseResource;
use App\Services\analytics\CategoryBalanceService;
use App\Services\Service;

class PeriodByCategoryAnalyticsResource extends BaseResource
{
    public function toArray($request): array
    {
        $service = new Service();

        return [
            'id' => $this->id,
            'period' => $this->period,
            'count' => strval($this->count),
            'balance' => $service->floatFormat($this->balance),
            'categories_in' => $this->categories_in,
            'categories_in_without_balance' => $this->categories_in_without_balance,
            'categories_out' => $this->categories_out,
            'categories_out_without_balance' => $this->categories_out_without_balance,
        ];
    }
}
