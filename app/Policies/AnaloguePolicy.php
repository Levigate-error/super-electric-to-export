<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AnaloguePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function search(?User $user): bool
    {
        if (!$user && $session = Auth::guard()->getSession()) {
            return true;
        }

        return $user->hasPermission('analog.search');
    }
}
