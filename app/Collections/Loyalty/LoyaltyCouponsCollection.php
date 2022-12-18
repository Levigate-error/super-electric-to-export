<?php

namespace App\Collections\Loyalty;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Loyalty\LoyaltyCoupon;

/**
 * Class LoyaltyUserCollection
 * @package App\Collections\Loyalty
 */
class LoyaltyCouponsCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [LoyaltyCoupon::class];
}
