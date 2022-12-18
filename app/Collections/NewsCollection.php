<?php

namespace App\Collections;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\News;

/**
 * Class NewsCollection
 * @package App\Collections
 */
class NewsCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [News::class];
}
