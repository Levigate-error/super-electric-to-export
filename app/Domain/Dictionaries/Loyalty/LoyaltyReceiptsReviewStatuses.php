<?php

namespace App\Domain\Dictionaries\Loyalty;

use App\Domain\Dictionaries\BaseDictionary;

/**
 * Class LoyaltyReceiptsStatuses
 * @package App\Domain\Dictionaries\Loyalty
 */
class LoyaltyReceiptsReviewStatuses extends BaseDictionary
{
    public const NEW = 1;
    public const APPROVED = 2;
    public const CANCELED = 3;
    public const DELIVERED = 4;
    public const MODERATION = 5;
    public const PENDING = 6;


    /**
     * @return array
     */
    public static function getToHumanResource(): array
    {
        return [
            self::NEW => __('loyalty-program.receipt-review-status.new'),
            self::APPROVED => __('loyalty-program.receipt-review-status.approved'),
            self::CANCELED => __('loyalty-program.receipt-review-status.canceled'),
            self::MODERATION => __('loyalty-program.receipt-review-status.moderation'),
        ];
    }
}
