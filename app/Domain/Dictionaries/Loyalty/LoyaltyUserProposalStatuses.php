<?php

namespace App\Domain\Dictionaries\Loyalty;

use App\Domain\Dictionaries\BaseDictionary;

/**
 * Class LoyaltyUserProposalStatuses
 * @package App\Domain\Dictionaries\Loyalty
 */
class LoyaltyUserProposalStatuses extends BaseDictionary
{
    public const NEW = 'new';
    public const PROCESSING = 'processing';
    public const APPROVED = 'approved';
    public const CANCELED = 'canceled';

    /**
     * @return array
     */
    public static function getToHumanResource(): array
    {
        return [
            self::NEW => __('loyalty-program.proposal-status.new'),
            self::PROCESSING => __('loyalty-program.proposal-status.processing'),
            self::APPROVED => __('loyalty-program.proposal-status.approved'),
            self::CANCELED => __('loyalty-program.proposal-status.canceled'),
        ];
    }
}
