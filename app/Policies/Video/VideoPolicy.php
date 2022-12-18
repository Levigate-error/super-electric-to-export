<?php

namespace App\Policies\Video;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Policies\BasePolicy;

/**
 * Class VideoPolicy
 * @package App\Policies\Video
 */
class VideoPolicy extends BasePolicy
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

        return $user->hasPermission('video.index');
    }

    /**
     * @param User|null $user
     * @return bool
     */
    public function search(?User $user): bool
    {
        if ($this->hasSessionWithoutUser($user)) {
            return true;
        }

        return $user->hasPermission('video.search');
    }
}
