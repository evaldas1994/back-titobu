<?php

namespace App\Http\Resources\category;

use App\Http\Resources\BaseResource;
use App\Http\Resources\transfer\TransferCollection;
use App\Services\Service;

class CategoryResource extends BaseResource
{
    public function toArray($request): array
    {
        $service = new Service();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'balance' => $service->floatFormat($this->balance),
            'type' => $this->type,
            'account_id' => $this->account_id,
            'account_name' => $this->account->name,
            'purpose_id' => $this->purpose_id,
            'purpose_name' => $this->purpose?->name,
            'transfers' => new TransferCollection($this->transfers),
            'icon' => $this->icon
        ];
    }
}
