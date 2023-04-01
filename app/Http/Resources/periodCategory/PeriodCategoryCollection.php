<?php

namespace App\Http\Resources\periodCategory;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PeriodCategoryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
