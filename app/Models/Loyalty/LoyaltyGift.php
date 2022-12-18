<?php

namespace App\Models\Loyalty;

use App\Collections\Loyalty\LoyaltyGiftsCollection;
use App\Models\BaseModel;
use App\Models\User;
use App\Models\Image;
use Illuminate\Notifications\Notifiable;
use App\Notifications\HasNotificationTransport;
use App\Traits\HasExternalEntity;

class LoyaltyGift extends BaseModel
{
    use Notifiable;
    use HasNotificationTransport;
    use HasExternalEntity;

    protected $fillable = ['user_id', 'gift_id', 'status_id'];

    const GIFT_POINTS_OLD = [1 => 50, 2 => 150, 3 => 250, 4 => 300, 5 => 350, 6 => 350, 7 => 400, 8 => 450, 9 => 450, 10 => 550, 11 => 750, 12 => 150];

    const GIFT_POINTS = [1 => 150, 2 => 300, 3 => 650, 4 => 450, 5 => 550, 6 => 600, 7 => 550, 8 => 500, 9 => 500, 10 => 900, 11 => 900,
        12 => 1100, 13 => 550, 14 => 150, 15 => 250, 16 => 50, 17 => 100, 18 => 300];

    const GIFT_COUNTS = [1 => 49, 2 => 9, 3 => 10, 4 => 18, 5 => 10, 6 => 10, 7 => 17, 8 => 20, 9 => 20, 10 => 6, 11 => 5,
        12 => 11, 13 => 6, 14 => 25, 15 => 10, 16 => 70, 17 => 22, 18 => 9];

    /**
     * @param array $models
     * @return LoyaltyGiftsCollection
     */
    public function newCollection(array $models = []): LoyaltyGiftsCollection
    {
        return new LoyaltyGiftsCollection($models);
    }

    /**
     * @return belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return hasOne
     */
    public function gift()
    {
        return $this->hasOne('App\Models\Loyalty\Gift', 'id', 'gift_id');
    }

    /**
     * @return MorphMany
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
