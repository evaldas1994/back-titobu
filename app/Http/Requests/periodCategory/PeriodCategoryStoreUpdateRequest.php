<?php

namespace App\Http\Requests\periodCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Category;
use App\Models\Period;

class PeriodCategoryStoreUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'limit' => ['required','numeric', 'min:0.01','max:999999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
            'period_id' => ['required', Rule::exists(Period::TABLE_NAME, 'id')],
            'category_id' => ['required', Rule::exists(Category::TABLE_NAME, 'id')],
        ];
    }
}
