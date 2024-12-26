<?php

namespace App\Http\Controllers\API\Auth\Input;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fio' => ['required', 'regex:/^[а-яА-ЯёЁ\s\-]+$/u'],
            'birthday' => ['required', 'date'],
            'passport' => ['required', 'numeric', 'unique:users'],
            'login' => ['required', 'alpha_dash', 'unique:users'],
            'phone' => ['required', 'numeric', 'unique:users'],
            'email' => ['required', 'email:rfc,dns', 'unique:users'],
            'password' => ['required', 'min:6'],
            'password_repeat' => ['required', 'same:password'],
            'rules' => ['required', 'in:on'],
        ];
    }
}
