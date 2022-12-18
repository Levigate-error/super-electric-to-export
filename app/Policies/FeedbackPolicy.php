<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class FeedbackPolicy
 * @package App\Policies
 */
class FeedbackPolicy
{
    use HandlesAuthorization;

    /**
     * @param User|null $user
     * @return bool
     */
    public function create(?User $user): bool
    {
        if ($user === null) {
            return true;
        }

        return $user->hasPermission('feedback.create');
    }
}
