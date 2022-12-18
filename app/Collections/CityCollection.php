<?php

namespace App\Collections;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\City;

/**
 * Class CityCollection
 * @package App\Collections
 */
class CityCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [City::class];
}
