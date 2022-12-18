<?php

namespace App\Rules;

use App\Domain\Dictionaries\Feedback\FeedbackTypes;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class FeedbackTypeRule
 * @package App\Rules
 */
class FeedbackTypeRule implements Rule
{
    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!is_string($value)) {
            return false;
        }

        return FeedbackTypes::checkExist($value);
    }

    /**
     * @return array|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function message()
    {
        return trans('validation.exists');
    }
}
