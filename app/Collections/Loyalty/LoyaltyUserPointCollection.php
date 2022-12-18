<?php

namespace App\Collections\Loyalty;

use App\Models\Loyalty\LoyaltyUserPoint;
use App\Collections\EloquentTypedCollection as TypedCollection;

/**
 * Class LoyaltyUserPointCollection
 * @package App\Collections\Loyalty
 */
class LoyaltyUserPointCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [LoyaltyUserPoint::class];
}
