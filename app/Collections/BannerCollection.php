<?php

namespace App\Collections;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Banner;

/**
 * Class BannerCollection
 * @package App\Collections
 */
class BannerCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [Banner::class];
}
