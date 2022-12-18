<?php

namespace App\Collections;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Analogue;

/**
 * Class AnalogCollection
 * @package App\Collections
 */
class AnalogCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [Analogue::class];
}
