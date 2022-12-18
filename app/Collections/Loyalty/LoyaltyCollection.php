<?php

namespace App\Collections\Loyalty;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Loyalty\Loyalty;

/**
 * Class LoyaltyCollection
 * @package App\Collections\Loyalty
 */
class LoyaltyCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [Loyalty::class];
}
