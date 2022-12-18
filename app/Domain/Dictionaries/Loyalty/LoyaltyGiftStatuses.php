<?php

namespace App\Domain\Dictionaries\Loyalty;

use App\Domain\Dictionaries\BaseDictionary;

/**
 * Class LoyaltyReceiptsStatuses
 * @package App\Domain\Dictionaries\Loyalty
 */
class LoyaltyGiftStatuses extends BaseDictionary
{
    public const NEW = 1;
    public const APPROVED = 2;
    public const CANCELED = 3;
    public const DELIVERED = 4;

    /**
     * @return array
     */
    public static function getToHumanResource(): array
    {
        return [
            self::NEW => __('loyalty-program.gifts.new'),
            self::APPROVED => __('loyalty-program.gifts.approved'),
            self::CANCELED => __('loyalty-program.gifts.canceled'),
            self::DELIVERED => __('loyalty-program.gifts.delivered'),
        ];
    }
}
