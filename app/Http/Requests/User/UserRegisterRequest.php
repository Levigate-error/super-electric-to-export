<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserRegisterRequest
 * @package App\Http\Requests\User
 */
class UserRegisterRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|min:2|max:128',
            'last_name' => 'required|string|min:2|max:128',
            'city_id' => 'required|integer|exists:cities,id',
            'phone' => 'required|string|max:32',
            'email' => 'required|string|email:rfc,dns,strict,spoof,filter|max:255|unique:users',
            'password' => 'required|string|min:8|max:50|confirmed',
            'personal_data_agreement' => 'required|accepted',
            //'email_subscription' => 'required|accepted',
            'birthday' => 'required|date_format:Y-m-d'
        ];
    }
}
