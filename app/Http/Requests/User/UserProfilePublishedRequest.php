<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserProfilePublishedRequest
 * @package App\Http\Requests\User
 */
class UserProfilePublishedRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'published' => 'required|boolean',
            'show_contacts' => 'boolean',
        ];
    }
}
