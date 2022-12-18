<?php

namespace App\Domain\Repositories\User;

use App\Collections\User\UserCollection;
use App\Domain\Repositories\MustHaveGetSource;
use App\Models\User;

/**
 * Interface UserRepositoryContract
 * @package App\Domain\Repositories\User
 */
interface UserRepositoryContract extends MustHaveGetSource
{
    /**
     * @param int $userId
     * @return User|null
     */
    public function getUser(int $userId): ?User;

    /**
     * @param array $params
     * @return UserCollection
     */
    public function getUsersByParams(array $params): UserCollection;
}
