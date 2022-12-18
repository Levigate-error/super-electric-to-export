<?php

namespace App\Repositories\Loyalty;

use App\Models\Loyalty\LoyaltyUserCategory;
use App\Domain\Repositories\Loyalty\LoyaltyUserCategoryRepositoryContract;
use App\Repositories\BaseRepository;
use App\Collections\Loyalty\LoyaltyUserCategoryCollection;

/**
 * Class LoyaltyUserCategoryRepository
 * @package App\Repositories\Loyalty
 */
class LoyaltyUserCategoryRepository extends BaseRepository implements LoyaltyUserCategoryRepositoryContract
{
    /**
     * @var string
     */
    protected $source = LoyaltyUserCategory::class;

    /**
     * @return LoyaltyUserCategoryCollection
     */
    public function getList(): LoyaltyUserCategoryCollection
    {
        return $this->getQueryBuilder()->orderBy('points')->get();
    }

    /**
     * @param int $points
     * @return LoyaltyUserCategory|null
     */
    public function getCategoryByPoints(int $points): ?LoyaltyUserCategory
    {
        $query = $this->getQueryBuilder();

        return $query->where('points', '>=', $points)
            ->orderBy('points')
            ->first();
    }
}
