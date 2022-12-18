<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserProfileRequest
 * @package App\Http\Requests\User
 */
class UserProfileRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => 'string|max:128',
            'last_name' => 'string|max:128',
            'city_id' => 'required|integer|exists:cities,id',
            'phone' => 'string|max:32',
            'email' => 'email|max:255|unique:users',
            'personal_site' => 'string|nullable|max:128',
            'email_subscription' => 'boolean',
        ];
    }
}
