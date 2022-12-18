<?php

namespace App\Domain\Dictionaries\Loyalty;

use App\Domain\Dictionaries\BaseDictionary;

/**
 * Class LoyaltyReceiptsStatuses
 * @package App\Domain\Dictionaries\Loyalty
 */
class LoyaltyUserPrizeWinningStatuses extends BaseDictionary
{
    public const NEW = 1;
    public const APPROVED = 2;
    public const CANCELED = 3;

    /**
     * @return array
     */
    public static function getToHumanResource(): array
    {
        return [
            self::NEW => __('loyalty-program.winning.new'),
            self::APPROVED => __('loyalty-program.winning.approved'),
            self::CANCELED => __('loyalty-program.winning.canceled'),
        ];
    }
}
