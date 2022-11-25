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
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'balance' => $this->floatFormat($this->balance),
            'type' => $this->type,
            'account_id' => $this->account_id,
            'account_name' => $this->account->name,
            'transfers' => new TransferCollection($this->transfers),
        ];
    }
}
