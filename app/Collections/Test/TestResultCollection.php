<?php

namespace App\Collections\Test;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Test\TestResult;

/**
 * Class TestResultCollection
 * @package App\Collections\Test
 */
class TestResultCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [TestResult::class];
}
