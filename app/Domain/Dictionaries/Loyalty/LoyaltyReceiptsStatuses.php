<?php

namespace App\Domain\Dictionaries\Loyalty;

use App\Domain\Dictionaries\BaseDictionary;

/**
 * Class LoyaltyReceiptsStatuses
 * @package App\Domain\Dictionaries\Loyalty
 */
class LoyaltyReceiptsStatuses extends BaseDictionary
{
    public const UNPROCESSED = 1;
    public const PROCESSED = 2;

    /**
     * @return array
     */
    public static function getToHumanResource(): array
    {
        return [
            self::UNPROCESSED => __('loyalty-program.receipt-types.unprocessed'),
            self::PROCESSED => __('loyalty-program.receipt-types.processed'),
        ];
    }
}
