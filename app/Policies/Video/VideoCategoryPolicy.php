<?php

namespace App\Policies\Video;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Policies\BasePolicy;

/**
 * Class VideoCategoryPolicy
 * @package App\Policies\Video
 */
class VideoCategoryPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * @param User|null $user
     * @return bool
     */
    public function getList(?User $user): bool
    {
        if ($this->hasSessionWithoutUser($user)) {
            return true;
        }

        return $user->hasPermission('video.category.list');
    }
}
