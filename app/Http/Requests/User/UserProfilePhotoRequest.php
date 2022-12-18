<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserProfilePhotoRequest
 * @package App\Http\Requests\User
 */
class UserProfilePhotoRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'photo' => 'required|image',
        ];
    }
}
