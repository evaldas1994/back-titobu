<?php

namespace App\Http\Requests\user;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserStoreUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $unique = in_array($this->method(), ['PUT', 'PATCH'])
            ? Rule::unique(User::TABLE_NAME)->ignore($this->user)
            : Rule::unique(User::TABLE_NAME);

        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', $unique],
            'password' => ['required', 'string', 'max:255'],
        ];
    }
}
