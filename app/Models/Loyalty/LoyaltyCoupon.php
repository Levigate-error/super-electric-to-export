<?php

namespace App\Models\Loyalty;

use App\Collections\Loyalty\LoyaltyCouponsCollection;
use App\Models\BaseModel;
use Illuminate\Notifications\Notifiable;
use App\Notifications\HasNotificationTransport;
use App\Traits\HasExternalEntity;

class LoyaltyCoupon extends BaseModel
{
    use Notifiable;
    use HasNotificationTransport;
    use HasExternalEntity;

    protected $fillable = ['code', 'used'];

    /**
     * @param array $models
     * @return LoyaltyGiftsCollection
     */
    public function newCollection(array $models = []): LoyaltyCouponsCollection
    {
        return new LoyaltyCouponsCollection($models);
    }
}
