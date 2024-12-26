<?php

namespace App\Http\Controllers\API\Auth\Input;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'alpha_dash', 'exists:users'],
            'password' => ['required', 'min:6'],
        ];
    }
}
