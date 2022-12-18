<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class BasePolicy
 * @package App\Policies
 */
class BasePolicy
{
    /**
     * @param User|null $user
     * @return bool
     */
    protected function hasSessionWithoutUser(?User $user): bool
    {
        return ($user === null) && (empty(Auth::guard()->getSession()) === false);
    }
}
