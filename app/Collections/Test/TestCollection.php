<?php

namespace App\Collections\Test;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Test\Test;

/**
 * Class TestCollection
 * @package App\Collections\Test
 */
class TestCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [Test::class];
}
