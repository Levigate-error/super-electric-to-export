<?php

namespace App\Collections\User;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\User;

/**
 * Class UserCollection
 * @package App\Collections\User
 */
class UserCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [User::class];
}
