<?php

namespace App\Collections\Loyalty;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Loyalty\LoyaltyUserCategory;

/**
 * Class LoyaltyUserCategoryCollection
 * @package App\Collections\Loyalty
 */
class LoyaltyUserCategoryCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [LoyaltyUserCategory::class];
}
