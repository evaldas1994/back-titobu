<?php

namespace App\Http\Resources\category;

use App\Http\Resources\BaseResource;
use App\Http\Resources\transfer\TransferCollection;
use App\Services\Service;

class CategoryResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'type' => $this->type,
            'type_name' => trans('category.types.' . $this->type),
            'icon' => $this->icon,
            'color' => $this->color,
            'color_name' => trans('category.colors.' . $this->color),
        ];
    }
}
