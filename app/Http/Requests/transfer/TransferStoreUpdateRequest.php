<?php

namespace App\Http\Requests\transfer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Category;
use App\Models\Period;

class TransferStoreUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'amount' => ['required','numeric', 'min:0.01','max:999999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
            'category_id' => ['required','integer', Rule::exists(Category::TABLE_NAME, 'id')],
            'period_id' => ['nullable','integer', Rule::exists(Period::TABLE_NAME, 'id')],
        ];
    }
}
