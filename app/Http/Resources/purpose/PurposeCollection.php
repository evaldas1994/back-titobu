<?php

namespace App\Http\Resources\purpose;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PurposeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
