<?php

namespace App\Domain\Repositories\Loyalty;

use App\Collections\Loyalty\LoyaltyUserCategoryCollection;
use App\Domain\Repositories\MustHaveGetSource;
use App\Models\Loyalty\LoyaltyUserCategory;

/**
 * Interface LoyaltyUserCategoryRepositoryContract
 * @package App\Domain\Repositories\Loyalty
 */
interface LoyaltyUserCategoryRepositoryContract extends MustHaveGetSource
{
    /**
     * @return LoyaltyUserCategoryCollection
     */
    public function getList(): LoyaltyUserCategoryCollection;

    /**
     * @param int $points
     * @return LoyaltyUserCategory|null
     */
    public function getCategoryByPoints(int $points): ?LoyaltyUserCategory;
}
