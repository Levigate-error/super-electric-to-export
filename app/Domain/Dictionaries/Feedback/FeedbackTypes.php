<?php

namespace App\Domain\Dictionaries\Feedback;

use App\Domain\Dictionaries\BaseDictionary;

/**
 * Class FeedbackTypes
 * @package App\Domain\Dictionaries\Feedback
 */
class FeedbackTypes extends BaseDictionary
{
    public const COMMON = 'common';
    public const HELP = 'help';

    /**
     * @return array
     */
    public static function getToHumanResource(): array
    {
        return [
            self::COMMON => __('feedback.type.common'),
            self::HELP => __('feedback.type.help'),
        ];
    }
}
