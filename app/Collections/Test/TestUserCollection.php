<?php

namespace App\Collections\Test;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Test\TestUser;

/**
 * Class TestUserCollection
 * @package App\Collections\Test
 */
class TestUserCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [TestUser::class];
}
