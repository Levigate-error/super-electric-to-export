<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;

/**
 * Class BaseValidator
 * @package App\Validators
 */
class BaseValidator
{
    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @param array $attribute
     * @return array
     */
    public function validate(array $attribute): array
    {
        $messages = [
            'required' => '":attribute" ' . trans('validation.must_set_in_profile'),
        ];

        $validator = Validator::make($attribute, $this->rules, $messages);

        return $validator->errors()->getMessages();
    }
}
