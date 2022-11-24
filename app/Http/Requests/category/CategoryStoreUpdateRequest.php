<?php

namespace App\Http\Requests\category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Category;
use App\Models\Account;

class CategoryStoreUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'balance' => ['required', 'numeric', 'min:0','max:999999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
            'type' => ['required', 'string', 'max:100', Rule::in(Category::getTypes())],
            'account_id' => ['nullable','integer', Rule::exists(Account::TABLE_NAME, 'id')],
        ];
    }
}
