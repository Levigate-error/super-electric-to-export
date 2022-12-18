<?php

namespace App\Admin\Services\User\Imports\Avito;

use App\Domain\Dictionaries\Users\SourceDictionary;
use App\Domain\ServiceContracts\Imports\Avito\AvitoUserSaverContract;
use App\Domain\ServiceContracts\User\UserServiceContract;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

/**
 * Class AvitoUserImportSaver
 *
 * Сервис сохранения пользователей Авито.
 *
 * @package App\Admin\Services\User\Imports\Avito
 */
class AvitoUserSaver implements AvitoUserSaverContract
{
    /**
     * @var UserServiceContract
     */
    protected $userService;

    public function __construct(UserServiceContract $userService)
    {
        $this->userService = $userService;
    }

    /**
     * {@inheritDoc}
     */
    public function save(AvitoUser $avitoUser): User
    {
        $sourceClass = $this->userService->getRepository()->getSource();

        /** @var User $user */
        $isExist = $sourceClass::query()
            ->where('email', '=', $avitoUser->getEmail())
            ->exists();

        if ($isExist === true) {
            throw new RuntimeException('User already exist.');
        }

        $user = User::createUser([
            'first_name' => $avitoUser->getFirstName(),
            'last_name'  => $avitoUser->getLastName(),
            'email'      => $avitoUser->getEmail(),
            'phone'      => $avitoUser->getPhone(),
//            'birthday'  => $avitoUser->getBirthday(),
//            'personal_site'  => $avitoUser->getPersonalSite(),
//            'password'   => $avitoUser->getPassword(),
            'source'     => SourceDictionary::AVITO_IMPORT,
        ]);

        event(new Registered($user));

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function batchSave(AvitoUserCollection $avitoUserCollection): int
    {
        $count = 0;
        foreach ($avitoUserCollection->all() as $avitoUser) {
            try {
                $this->save($avitoUser);
                $count++;
            } catch (Throwable $exception) {
                Log::error($exception->getMessage());
                continue;
            }
        }

        return $count;
    }
}
