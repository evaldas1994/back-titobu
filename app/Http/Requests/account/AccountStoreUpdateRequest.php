<?php

namespace App\Http\Requests\account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

class AccountStoreUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'balance' => ['required','numeric', 'min:0','max:999999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
        ];
    }
}
