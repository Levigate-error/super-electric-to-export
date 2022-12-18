<?php

namespace App\Models\Loyalty;

use App\Collections\Loyalty\LoyaltyReceiptsCollection;
use App\Models\BaseModel;
use App\Models\User;
use App\Models\Image;
use Illuminate\Notifications\Notifiable;
use App\Notifications\HasNotificationTransport;
use App\Traits\HasExternalEntity;

class LoyaltyReceipt extends BaseModel
{
    use Notifiable;
    use HasNotificationTransport;
    use HasExternalEntity;

    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $casts = [
        'amount' => 'float',
    ];

    /**
     * @param array $models
     * @return LoyaltyReceiptsCollection
     */
    public function newCollection(array $models = []): LoyaltyReceiptsCollection
    {
        return new LoyaltyReceiptsCollection($models);
    }

    /**
     * @return hasOneThrough
     */
    public function user()
    {
        return $this->hasOneThrough(User::class, LoyaltyUser::class, 'id', 'id', 'loyalty_user_id', 'user_id');
    }

    /**
     * @return belongsTo
     */
    public function loyaltyUser()
    {
        return $this->belongsTo(LoyaltyUser::class);
    }

    /**
     * @return MorphMany
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @return belongsTo
     */
    public function loyaltyUserPoints()
    {
        return $this->belongsTo(LoyaltyUserPoint::class, 'loyalty_user_id', 'loyalty_user_id');
    }
}
