<?php

namespace App\Policies\Test;

use App\Models\User;
use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class TestPolicy
 * @package App\Policies\Test
 */
class TestPolicy extends BasePolicy
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

        return $user->hasPermission('test.index');
    }

    /**
     * @param User|null $user
     * @return bool
     */
    public function show(?User $user): bool
    {
        if ($this->hasSessionWithoutUser($user)) {
            return true;
        }

        return $user->hasPermission('test.show');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function register(User $user): bool
    {
        return $user->hasPermission('test.register');
    }
}
