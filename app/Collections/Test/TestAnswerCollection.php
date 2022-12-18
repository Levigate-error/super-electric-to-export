<?php

namespace App\Collections\Test;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Test\TestAnswer;

/**
 * Class TestAnswerCollection
 * @package App\Collections\Test
 */
class TestAnswerCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [TestAnswer::class];
}
