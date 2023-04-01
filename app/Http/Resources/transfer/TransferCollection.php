<?php

namespace App\Http\Resources\transfer;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Services\Service;

class TransferCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
