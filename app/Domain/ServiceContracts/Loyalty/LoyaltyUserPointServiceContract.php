<?php

namespace App\Domain\ServiceContracts\Loyalty;

use App\Collections\Loyalty\LoyaltyUserPointCollection;
use App\Domain\Repositories\Loyalty\LoyaltyUserPointRepositoryContract;

/**
 * Interface LoyaltyUserPointServiceContract
 * @package App\Domain\ServiceContracts\Loyalty
 */
interface LoyaltyUserPointServiceContract
{
    /**
     * @return LoyaltyUserPointRepositoryContract
     */
    public function getRepository(): LoyaltyUserPointRepositoryContract;

    /**
     * @param int $userPointId
     * @return bool
     */
    public function reCalcPoints(int $userPointId): bool;

    /**
     * @param int $userPointId
     * @return bool
     */
    public function setLastPlace(int $userPointId): bool;

    /**
     * @param int $userPoints
     * @param LoyaltyUserPointCollection $loyaltyUsersPoints
     * @return int
     */
    public function getPointsGap(int $userPoints, LoyaltyUserPointCollection $loyaltyUsersPoints): int;

    /**
     * @param int $userPointId
     * @param int $points
     * @param int $pointsGap
     * @return bool
     */
    public function setPlaceAndPointsGap(int $userPointId, int $points, int $pointsGap): bool;

    /**
     * @param int $loyaltyId
     * @return bool
     */
    public function reCalcUsersPointsAndPlaces(int $loyaltyId): bool;
}
