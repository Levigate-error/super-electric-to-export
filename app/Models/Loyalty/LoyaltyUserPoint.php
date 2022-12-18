<?php

namespace App\Models\Loyalty;

use App\Collections\Loyalty\LoyaltyUserPointCollection;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class LoyaltyUserPoint
 * @package App\Models\Loyalty
 */
class LoyaltyUserPoint extends BaseModel
{
    private const POINTS_PER_PRODUCT_CODE = 1;

    /**
     * @var array
     */
    protected $fillable = ['points', 'loyalty_user_id', 'place', 'points_gap'];

    /**
     * @param array $models
     * @return LoyaltyUserPointCollection
     */
    public function newCollection(array $models = []): LoyaltyUserPointCollection
    {
        return new LoyaltyUserPointCollection($models);
    }

    /**
     * @return BelongsTo
     */
    public function loyaltyUser(): BelongsTo
    {
        return $this->belongsTo(LoyaltyUser::class);
    }

    /**
     * @return HasMany
     */
    public function loyaltyUserProposals(): HasMany
    {
        return $this->hasMany(LoyaltyUserProposal::class);
    }

    /**
     * @return int
     */
    public static function getPointPerProductCode(): int
    {
        return self::POINTS_PER_PRODUCT_CODE;
    }

    /**
     * @param int $userPointId
     * @param int $place
     * @param int $pointsGap
     * @return bool
     */
    public static function setUserPointPlaceAndGap(int $userPointId, int $place, int $pointsGap): bool
    {
        $userPoint = self::query()->findOrFail($userPointId);

        $userPoint->place = $place;
        $userPoint->points_gap = $pointsGap;

        return $userPoint->saveQuietly();
    }
}
