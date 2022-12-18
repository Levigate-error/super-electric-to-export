<?php

namespace App\Collections\Loyalty;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Loyalty\Gift;

/**
 * Class LoyaltyUserCollection
 * @package App\Collections\Loyalty
 */
class GiftsCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [Gift::class];
}
