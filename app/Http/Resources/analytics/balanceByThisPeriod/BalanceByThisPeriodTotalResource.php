<?php

namespace App\Http\Resources\analytics\balanceByThisPeriod;

use App\Http\Resources\BaseResource;
use App\Services\analytics\CategoryBalanceService;
use App\Services\Service;

class BalanceByThisPeriodTotalResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'earnings' => $this->earnings,
            'expenses' => $this->expenses,
        ];
    }
}
