<?php

namespace App\Repositories\Loyalty;

use App\Models\Loyalty\LoyaltyUser;
use App\Domain\Repositories\Loyalty\LoyaltyUserRepositoryContract;
use App\Repositories\BaseRepository;
use App\Collections\Loyalty\LoyaltyUserCollection;

/**
 * Class LoyaltyUserRepository
 * @package App\Repositories\Loyalty
 */
class LoyaltyUserRepository extends BaseRepository implements LoyaltyUserRepositoryContract
{
    /**
     * @var string
     */
    protected $source = LoyaltyUser::class;

    /**
     * @param array $params
     * @return LoyaltyUserCollection
     */
    public function getLoyaltyUsersByParams(array $params): LoyaltyUserCollection
    {
        return $this->getQueryBuilder()->where($params)->with('loyaltyUserWinnings')->get();
    }
}
