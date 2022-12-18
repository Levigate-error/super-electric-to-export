<?php

namespace App\Collections\User;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\UserActivity;

/**
 * Class UserActivityCollection
 * @package App\Collections\User
 */
class UserActivityCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [UserActivity::class];
}
