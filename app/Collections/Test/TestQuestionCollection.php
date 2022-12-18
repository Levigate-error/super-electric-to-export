<?php

namespace App\Collections\Test;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Test\TestQuestion;

/**
 * Class TestQuestionCollection
 * @package App\Collections\Test
 */
class TestQuestionCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [TestQuestion::class];
}
