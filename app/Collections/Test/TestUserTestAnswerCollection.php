<?php

namespace App\Collections\Test;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Test\TestUserTestAnswer;

/**
 * Class TestUserTestAnswerCollection
 * @package App\Collections\Test
 */
class TestUserTestAnswerCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [TestUserTestAnswer::class];
}
