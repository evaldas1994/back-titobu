<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    protected function floatFormat(float $number) {
        return number_format((float)$number, 2, '.', ',');
    }

    protected function dateTimeFormat(string $dateTime, $format = 'Y-m-d H:i:s') {
        return Carbon::make($dateTime)->format($format);
    }
}
