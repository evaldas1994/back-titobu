<?php

namespace App\Http\Resources\periodCategory;

use App\Http\Resources\BaseResource;
use App\Services\Service;

class PeriodCategoryResource extends BaseResource
{
    public function toArray($request): array
    {
        $service = new Service();

        return [
            'id' => $this->id,
            'limit' => $service->floatFormat($this->limit),
            'period_id' => $this->period_id,
            'period_period' => $this->period->period,
            'category_id' => $this->category_id,
            'category_name' => $this->category->name,
            'user_id' => $this->user_id,
        ];
    }
}
