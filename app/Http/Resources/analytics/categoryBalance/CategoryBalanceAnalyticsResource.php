<?php

namespace App\Http\Resources\analytics\categoryBalance;

use App\Http\Resources\BaseResource;
use App\Services\analytics\CategoryBalanceService;
use App\Services\Service;

class CategoryBalanceAnalyticsResource extends BaseResource
{
    public function toArray($request): array
    {
        $service = new Service();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'purpose_id' => $this->purpose_id,
            'balance' => $service->floatFormat((new CategoryBalanceService())->calculateBalance($this->resource)),
            'account_balance' => $service->floatFormat($this->account->balance),
            'balance_month' => $service->floatFormat($this->balance),
            'balance_day' => $service->floatFormat((new CategoryBalanceService())->calculateBalanceDay($this->resource)),
            'balance_today' => $service->floatFormat((new CategoryBalanceService())->calculateBalanceToday($this->resource)),
            'icon' => $this->icon,
        ];
    }
}
