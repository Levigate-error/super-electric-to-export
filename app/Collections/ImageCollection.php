<?php

namespace App\Collections;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Image;

/**
 * Class ImageCollection
 * @package App\Collections
 */
class ImageCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [Image::class];
}
