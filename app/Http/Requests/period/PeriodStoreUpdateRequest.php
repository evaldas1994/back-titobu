<?php

namespace App\Http\Requests\period;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PeriodStoreUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'period' => ['required', 'string', 'max:100'],
        ];
    }
}
