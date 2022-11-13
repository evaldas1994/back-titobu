<?php

namespace App\Http\Resources\category;

use App\Http\Resources\BaseResource;
use App\Http\Resources\transfer\TransferCollection;

class CategoryResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'balance' => $this->floatFormat($this->balance),
            'type' => $this->type,
            'transfers' => new TransferCollection($this->transfers),
        ];
    }
}
