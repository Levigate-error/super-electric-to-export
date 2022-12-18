<?php

namespace App\Domain\Dictionaries\Feedback;

use App\Domain\Dictionaries\BaseDictionary;

/**
 * Class FeedbackStatuses
 * @package App\Domain\Dictionaries\Feedback
 */
class FeedbackStatuses extends BaseDictionary
{
    public const NEW = 'new';
    public const VIEWED = 'viewed';
    public const PROCESSED = 'processed';

    /**
     * @return array
     */
    public static function getToHumanResource(): array
    {
        return [
            self::NEW => __('feedback.status.new'),
            self::VIEWED => __('feedback.status.viewed'),
            self::PROCESSED => __('feedback.status.processed'),
        ];
    }
}
