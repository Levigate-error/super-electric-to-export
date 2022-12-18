<?php

namespace App\Collections\Loyalty;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Loyalty\LoyaltyUser;

/**
 * Class LoyaltyUserCollection
 * @package App\Collections\Loyalty
 */
class LoyaltyUserCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [LoyaltyUser::class];
}
