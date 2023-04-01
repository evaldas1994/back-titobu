<?php

namespace App\Http\Resources\period;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PeriodCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
