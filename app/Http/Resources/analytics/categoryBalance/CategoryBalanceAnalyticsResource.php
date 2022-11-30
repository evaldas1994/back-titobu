<?php

namespace App\Http\Resources\analytics\categoryBalance;

use App\Http\Resources\BaseResource;
use App\Services\analytics\CategoryBalanceService;

class CategoryBalanceAnalyticsResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'purpose_id' => $this->purpose_id,
            'balance' => $this->floatFormat((new CategoryBalanceService())->calculateBalance($this->resource)),
            'account_balance' => $this->account->balance,
            'balance_month' => $this->floatFormat($this->balance),
            'balance_day' => $this->floatFormat((new CategoryBalanceService())->calculateBalanceDay($this->resource)),
            'balance_today' => $this->floatFormat((new CategoryBalanceService())->calculateBalanceToday($this->resource)),
            'icon' => $this->icon,
        ];
    }
}
