<?php

namespace App\Collections;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Faq;

/**
 * Class FaqCollection
 * @package App\Collections
 */
class FaqCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [Faq::class];
}
