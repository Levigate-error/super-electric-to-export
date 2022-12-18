<?php

namespace App\Policies\Loyalty;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class LoyaltyPolicy
 * @package App\Policies\Loyalty
 */
class LoyaltyPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function getList(User $user): bool
    {
        return $user->hasPermission('loyalty.list');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function userRegister(User $user): bool
    {
        return $user->hasPermission('loyalty.user.register');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function registerProductCode(User $user): bool
    {
        return $user->hasPermission('loyalty.register.product.code');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function getProposalsList(User $user): bool
    {
        return $user->hasPermission('loyalty.proposals.list');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function uploadReceipt(User $user): bool
    {
        return $user->hasPermission('loyalty.receipt.upload');
    }
}
