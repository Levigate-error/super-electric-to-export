<?php

namespace App\Domain\Repositories\Loyalty;

use App\Domain\Repositories\MustHaveGetSource;
use App\Models\Loyalty\LoyaltyProductCode;

/**
 * Interface LoyaltyProductCodeRepositoryContract
 * @package App\Domain\Repositories\Loyalty
 */
interface LoyaltyProductCodeRepositoryContract extends MustHaveGetSource
{
    /**
     * @param string $code
     * @return LoyaltyProductCode|null
     */
    public function getProductCodeByCode(string $code): ?LoyaltyProductCode;
}
