<?php

namespace App\Http\Resources\analytics\categoryByType;

use App\Services\Service;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Services\analytics\CategoryBalanceService;

class CategoryByTypeAnalyticsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $service = new Service();

        return [
            'data' => $this->collection,
        ];
    }
}
