<?php

namespace App\Http\Requests\category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Category;

class CategoryStoreUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:100'],
//            'balance' => ['required', 'numeric', 'min:0','max:999999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
            'type' => ['required', 'string', 'max:100', Rule::in(Category::getTypes())],
            'icon' => ['required','string', 'max:100'],
            'color' => ['required','string', 'max:100'],
        ];
    }
}
