<?php

namespace App\Http\Resources\transfer;

use App\Http\Resources\BaseResource;
use App\Services\Service;
use Carbon\Carbon;

class TransferResource extends BaseResource
{
    public function toArray($request): array
    {
        $service = new Service();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'amount' => $service->floatFormat($this->amount),
            'category_id' => $this->category_id,
            'category_name' => $this->category->name,
            'period_id' => $this->period_id,
            'period_name' => $this->period->name,
            'created_at' => $service->dateTimeFormat($this->created_at, 'Y-m-d H:i'),
        ];
    }
}
