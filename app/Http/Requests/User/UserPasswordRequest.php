<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserPasswordRequest
 * @package App\Http\Requests\User
 */
class UserPasswordRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'current_password' => 'required|string|current_password',
            'new_password' => 'required|string|min:8|max:50|confirmed',
        ];
    }
}
