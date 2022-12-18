<?php

namespace App\Collections\Loyalty;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Loyalty\LoyaltyReceipt;

/**
 * Class LoyaltyUserCollection
 * @package App\Collections\Loyalty
 */
class LoyaltyReceiptsCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [LoyaltyReceipt::class];
}
