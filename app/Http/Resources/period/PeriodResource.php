<?php

namespace App\Http\Resources\period;

use App\Http\Resources\BaseResource;

class PeriodResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'period' => $this->period,
        ];
    }
}
