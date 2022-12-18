<?php

namespace App\Domain\Repositories\Loyalty;

use App\Collections\Loyalty\LoyaltyUserCollection;
use App\Domain\Repositories\MustHaveGetSource;

/**
 * Interface LoyaltyUserRepositoryContract
 * @package App\Domain\Repositories\Loyalty
 */
interface LoyaltyUserRepositoryContract extends MustHaveGetSource
{
    /**
     * @param array $params
     * @return LoyaltyUserCollection
     */
    public function getLoyaltyUsersByParams(array $params): LoyaltyUserCollection;
}
