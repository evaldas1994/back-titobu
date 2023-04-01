<?php

namespace App\Http\Resources\analytics\analyticByCategory;

use App\Http\Resources\BaseResource;
use App\Services\analytics\CategoryBalanceService;
use App\Services\Service;

class AnalyticByCategoryAnalyticsResource extends BaseResource
{
    public function toArray($request): array
    {
        $service = new Service();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'purpose_id' => $this->purpose_id,
            'icon' => $this->icon,
            'color' => $this->color,

            'balance_expenses' => $this->balance_expenses,
            'balance_month' => $this->balance_month,

            'balance_day' => $this->balance_day,

            'balance' => $this->balance,
            'balance_today' => $this->balance_today,
        ];
    }
}
