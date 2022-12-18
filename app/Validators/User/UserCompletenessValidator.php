<?php

namespace App\Validators\User;

use App\Validators\BaseValidator;

/**
 * Класс для валидации полноты данных у юзера
 *
 * Class UserCompletenessValidator
 * @package App\Validators\User
 */
class UserCompletenessValidator extends BaseValidator
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
        'certificates' => 'required',
    ];
}
