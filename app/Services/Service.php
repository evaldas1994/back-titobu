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
}
