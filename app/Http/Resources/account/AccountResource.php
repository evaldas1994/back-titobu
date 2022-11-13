<?php

namespace App\Http\Resources\account;

use App\Http\Resources\transfer\TransferCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'balance' => $this->balance,
            'transfers' => new TransferCollection($this->transfers),
        ];
    }
}
