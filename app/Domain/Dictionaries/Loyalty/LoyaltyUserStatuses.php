<?php

namespace App\Domain\Dictionaries\Loyalty;

use App\Domain\Dictionaries\BaseDictionary;

/**
 * Class LoyaltyUserStatuses
 * @package App\Domain\Dictionaries\Loyalty
 */
class LoyaltyUserStatuses extends BaseDictionary
{
    public const NEW = 'new';
    public const APPROVED = 'approved';
    public const CANCELED = 'canceled';

    /**
     * @return array
     */
    public static function getToHumanResource(): array
    {
        return [
            self::NEW => __('loyalty-program.user-status.new'),
            self::APPROVED => __('loyalty-program.user-status.approved'),
            self::CANCELED => __('loyalty-program.user-status.canceled'),
        ];
    }
}
