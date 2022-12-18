<?php

namespace App\Validators\User;

use App\Validators\BaseValidator;

/**
 * Class UserProfileCompletenessValidator
 * @package App\Validators\User
 */
class UserProfileCompletenessValidator extends BaseValidator
{
    /**
     * @var array
     */
    protected $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'city' => 'required',
        'phone' => 'required',
        'email' => 'required',
        'photo' => 'required',
    ];
}
