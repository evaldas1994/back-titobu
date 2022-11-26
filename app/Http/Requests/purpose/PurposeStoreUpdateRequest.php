<?php

namespace App\Http\Requests\purpose;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PurposeStoreUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:100'],
        ];
    }
}
