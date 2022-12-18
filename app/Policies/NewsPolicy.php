<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class NewsPolicy
 * @package App\Policies
 */
class NewsPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * @param User|null $user
     * @return bool
     */
    public function index(?User $user): bool
    {
        if ($this->hasSessionWithoutUser($user)) {
            return true;
        }

        return $user->hasPermission('news.index');
    }

    /**
     * @param User|null $user
     * @return bool
     */
    public function details(?User $user): bool
    {
        if ($this->hasSessionWithoutUser($user)) {
            return true;
        }

        return $user->hasPermission('news.details');
    }
}
