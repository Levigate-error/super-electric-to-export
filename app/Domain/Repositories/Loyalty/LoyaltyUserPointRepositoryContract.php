<?php

namespace App\Domain\Repositories\Loyalty;

use App\Collections\Loyalty\LoyaltyUserPointCollection;
use App\Domain\Repositories\MustHaveGetSource;
use App\Models\Loyalty\LoyaltyUserPoint;

/**
 * Interface LoyaltyUserPointRepositoryContract
 * @package App\Domain\Repositories\Loyalty
 */
interface LoyaltyUserPointRepositoryContract extends MustHaveGetSource
{
    /**
     * @param int $userPointId
     * @return LoyaltyUserPoint
     */
    public function getUserPoint(int $userPointId): LoyaltyUserPoint;

    /**
     * @param int $loyaltyId
     * @return LoyaltyUserPointCollection
     */
    public function getLoyaltyUsersPoints(int $loyaltyId): LoyaltyUserPointCollection;
}
