<?php

namespace App\Http\Resources\transfer;

use App\Http\Resources\BaseResource;
use Carbon\Carbon;

class TransferResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'amount' => $this->floatFormat($this->amount),
            'category_id' => $this->category_id,
            'category_name' => $this->category->name,
            'account_id' => $this->account_id,
            'account_name' => $this->account->name,
            'created_at' => $this->dateTimeFormat($this->created_at, 'Y-m-d H:i'),
        ];
    }
}
