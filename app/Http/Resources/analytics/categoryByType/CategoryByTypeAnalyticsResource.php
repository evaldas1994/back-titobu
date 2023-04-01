<?php

namespace App\Http\Resources\analytics\categoryByType;

use App\Http\Resources\BaseResource;
use App\Services\analytics\CategoryBalanceService;
use App\Services\Service;

class CategoryByTypeAnalyticsResource extends BaseResource
{
    public function toArray($request): array
    {
        $service = new Service();

        $names = [
            'expenses' => 'Išlaidos',
            'incomes' => 'Pajamos',
        ];

        $colors = [
            'expenses' => 'red',
            'incomes' => 'green',
        ];

        return [
            'id' => $this->id,
            'count' => strval($this->count),
            'name' => $names[$this->id],
            'color' => $colors[$this->id],
        ];
    }
}
