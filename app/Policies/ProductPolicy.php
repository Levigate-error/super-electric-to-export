<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class ProductPolicy
 * @package App\Policies
 */
class ProductPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function workWithFavorite(User $user): bool
    {
        return $user->hasPermission('product.favorites');
    }

    /**
     * @param User|null $user
     * @return bool
     */
    public function recommended(?User $user): bool
    {
        if ($this->hasSessionWithoutUser($user)) {
            return true;
        }

        return $user->hasPermission('product.recommended');
    }

    /**
     * @param User|null $user
     * @return bool
     */
    public function buyWithIt(?User $user): bool
    {
        if ($this->hasSessionWithoutUser($user)) {
            return true;
        }

        return $user->hasPermission('product.buywithit');
    }
}
