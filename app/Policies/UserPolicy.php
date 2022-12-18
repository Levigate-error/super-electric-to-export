<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function profileUpdate(User $user): bool
    {
        return $user->hasPermission('user.profile.update');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function passwordUpdate(User $user): bool
    {
        return $user->hasPermission('user.password.update');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function profilePhotoUpdate(User $user): bool
    {
        return $user->hasPermission('user.profile.photo.update');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function profilePublishedUpdate(User $user): bool
    {
        return $user->hasPermission('user.profile.published.update');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->hasPermission('user.delete');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function profileCompletenessCheck(User $user): bool
    {
        return $user->hasPermission('user.profile.completeness.check');
    }
}
