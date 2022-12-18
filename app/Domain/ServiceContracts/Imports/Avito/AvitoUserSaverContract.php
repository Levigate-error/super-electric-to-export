<?php

namespace App\Domain\ServiceContracts\Imports\Avito;

use App\Admin\Services\User\Imports\Avito\AvitoUser;
use App\Admin\Services\User\Imports\Avito\AvitoUserCollection;
use App\Models\User;

/**
 * Interface AvitoUserSaverContract
 *
 * Контракт сохранения пользователей Авито.
 *
 * @package App\Domain\ServiceContracts\Imports\Avito
 */
interface AvitoUserSaverContract
{
    /**
     * Сохранить пользователя авито.
     *
     * @param AvitoUser $avitoUser
     *
     * @return User
     */
    public function save(AvitoUser $avitoUser): User;

    /**
     * Сохранить коллекцию пользоватлей Авито.
     *
     * @param AvitoUserCollection $avitoUserCollection
     *
     * @return int
     */
    public function batchSave(AvitoUserCollection $avitoUserCollection): int;
}
