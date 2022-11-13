<?php

namespace App\Http\Requests\transfer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Category;
use App\Models\Account;

class TransferStoreUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'amount' => ['required','numeric', 'min:0.01','max:999999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
            'category_id' => ['required','integer', Rule::exists(Category::TABLE_NAME, 'id')],
            'account_id' => ['required','integer', Rule::exists(Account::TABLE_NAME, 'id')],
        ];
    }
}
