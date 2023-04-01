<?php

namespace App\Http\Resources\analytics\earningByCategory;

use App\Http\Resources\BaseResource;
use App\Services\analytics\CategoryBalanceService;
use App\Services\Service;

class EarningByCategoryAnalyticsResource extends BaseResource
{
    public function toArray($request): array
    {
        $service = new Service();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'amount' => $service->floatFormat($this->amount),
            'color' => $this->color,
        ];
    }
}
