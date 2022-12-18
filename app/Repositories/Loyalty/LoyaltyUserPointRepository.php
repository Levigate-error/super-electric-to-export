<?php

namespace App\Repositories\Loyalty;

use App\Models\Loyalty\LoyaltyUserPoint;
use App\Domain\Repositories\Loyalty\LoyaltyUserPointRepositoryContract;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use App\Collections\Loyalty\LoyaltyUserPointCollection;

/**
 * Class LoyaltyUserPointRepository
 * @package App\Repositories\Loyalty
 */
class LoyaltyUserPointRepository extends BaseRepository implements LoyaltyUserPointRepositoryContract
{
    /**
     * @var string
     */
    protected $source = LoyaltyUserPoint::class;

    /**
     * @param int $userPointId
     * @return LoyaltyUserPoint
     */
    public function getUserPoint(int $userPointId): LoyaltyUserPoint
    {
        $query = $this->getQueryBuilder();

        return $query->findOrFail($userPointId);
    }

    /**
     * @param int $loyaltyId
     * @return LoyaltyUserPointCollection
     */
    public function getLoyaltyUsersPoints(int $loyaltyId): LoyaltyUserPointCollection
    {
        $query = $this->getQueryBuilder();

        return $query->whereHas('loyaltyUser', static function (Builder $userBuilder) use ($loyaltyId) {
            return $userBuilder->where(['loyalty_users.loyalty_id' =>  $loyaltyId]);
        })->orderByDesc('points')->get();
    }
}
