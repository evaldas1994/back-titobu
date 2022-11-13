<?php

namespace App\Http\Resources\analytics\categoryBalance;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryBalanceAnalyticsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
