<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            /**
             * User email address.
             *
             * @example test@example.com
             */
            'email' => ['required', 'email'],
            /**
             * User password.
             *
             * @example password
             */
            'password' => ['required', 'string'],
        ];
    }
}
