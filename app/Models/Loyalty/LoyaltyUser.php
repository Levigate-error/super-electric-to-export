<?php

namespace App\Models\Loyalty;

use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Collections\Loyalty\LoyaltyUserCollection;
use App\Domain\Dictionaries\Loyalty\LoyaltyUserStatuses;
use App\Models\Certificate;
use Illuminate\Notifications\Notifiable;
use App\Notifications\HasNotificationTransport;

/**
 * Class LoyaltyUser
 * @package App\Models\Loyalty
 */
class LoyaltyUser extends BaseModel
{
    use Notifiable;
    use HasNotificationTransport;

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'loyalty_certificate_id', 'loyalty_id', 'status', 'loyalty_user_category_id'];

    /**
     * @param array $models
     * @return LoyaltyUserCollection
     */
    public function newCollection(array $models = []): LoyaltyUserCollection
    {
        return new LoyaltyUserCollection($models);
    }

    /**
     * @return belongsTo
     */
    public function loyalty(): belongsTo
    {
        return $this->belongsTo(Loyalty::class);
    }

    /**
     * @return belongsTo
     */
    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function certificate(): BelongsTo
    {
        return $this->belongsTo(Certificate::class);
    }

    /**
     * @return HasOne
     */
    public function loyaltyUserPoint(): HasOne
    {
        return $this->hasOne(LoyaltyUserPoint::class);
    }

    /**
     * @return BelongsTo
     */
    public function loyaltyUserCategory(): BelongsTo
    {
        return $this->belongsTo(LoyaltyUserCategory::class);
    }

    public function loyaltyUserWinnings() :HasMany
    {
        return $this->hasMany(LoyaltyUserPrizeWinning::class);
    }
    /**
     * @return string
     */
    public function getStatusOnHumanAttribute(): string
    {
        return LoyaltyUserStatuses::toHuman($this->status);
    }

    /**
     * @param int $loyaltyId
     * @param int $userId
     * @param int $certificateId
     * @return static
     */
    public static function registerUser(int $loyaltyId, int $userId, int $certificateId): self
    {
        $model = new self([
            'loyalty_id' => $loyaltyId,
            'user_id' => $userId,
            'loyalty_certificate_id' => $certificateId,
            'status' => LoyaltyUserStatuses::NEW,
        ]);
        $model->trySaveModel();

        return $model->refresh();
    }

    /**
     * @param string $status
     * @return bool
     */
    public function setStatus(string $status): bool
    {
        $this->status = $status;

        return $this->trySaveModel();
    }

    /**
     * @param int $loyaltyUserId
     * @param int $userCategoryId
     * @return bool
     */
    public static function setUserCategory(int $loyaltyUserId, int $userCategoryId): bool
    {
        $model = self::query()->findOrFail($loyaltyUserId);

        $model->loyalty_user_category_id = $userCategoryId;

        return $model->saveQuietly();
    }

    public static function firstOrCreateUser(int $loyaltyId, int $userId, ?int $certificateId)
    {
        $loyaltyUser = self::firstOrCreate([
            'loyalty_id' => $loyaltyId,
            'user_id' => $userId,
        ], [
            'loyalty_certificate_id' => $certificateId,
            'status' => LoyaltyUserStatuses::NEW
        ]);
        return $loyaltyUser;
    }
}
