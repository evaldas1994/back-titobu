<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Arr;

class Service
{
    public function addUser(array $array): array
    {
        return Arr::set($array, 'user_id', auth()->id());
    }

    public function floatFormat(float $number) {
        return number_format((float)$number, 2, '.', ',');
    }

    public function dateTimeFormat(string $dateTime, $format = 'Y-m-d H:i:s') {
        return Carbon::make($dateTime)->format($format);
    }
}
