<?php

namespace App\Domain\ServiceContracts\Loyalty;

use App\Domain\Repositories\Loyalty\LoyaltyUserCategoryRepositoryContract;
use App\Http\Resources\Loyalty\LoyaltyUserCategoryResource;

/**
 * Interface LoyaltyUserCategoryServiceContract
 * @package App\Domain\ServiceContracts\Loyalty
 */
interface LoyaltyUserCategoryServiceContract
{
    /**
     * @return LoyaltyUserCategoryRepositoryContract
     */
    public function getRepository(): LoyaltyUserCategoryRepositoryContract;

    /**
     * @return array
     */
    public function getUserCategories(): array;

    /**
     * @param int $points
     * @return LoyaltyUserCategoryResource
     */
    public function getCategoryByPoints(int $points): LoyaltyUserCategoryResource;
}
