<?php

namespace App\Collections\Loyalty;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Loyalty\LoyaltyGift;
use App\Models\Loyalty\LoyaltyReceipt;

/**
 * Class LoyaltyUserCollection
 * @package App\Collections\Loyalty
 */
class LoyaltyGiftsCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [LoyaltyGift::class];
}
