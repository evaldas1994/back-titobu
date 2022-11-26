<?php

namespace App\Http\Resources\purpose;

use Illuminate\Http\Resources\Json\JsonResource;

class PurposeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
        ];
    }
}
