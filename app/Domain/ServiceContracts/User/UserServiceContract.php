<?php

namespace App\Domain\ServiceContracts\User;

use App\Domain\Repositories\User\UserRepositoryContract;
use App\Validators\BaseValidator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

/**
 * Interface UserServiceContract
 * @package App\Domain\ServiceContracts\User
 */
interface UserServiceContract
{
    /**
     * @return UserRepositoryContract
     */
    public function getRepository(): UserRepositoryContract;

    /**
     * @param int $userId
     * @return array
     */
    public function getUserProfile(int $userId): array;

    /**
     * @param int $userId
     * @param array $params
     * @return bool
     */
    public function updateUserProfile(int $userId, array $params): bool;

    /**
     * @param array $params
     * @return array
     */
    public function updateAndGetCurrentUserProfile(array $params): array;

    /**
     * @param string $newPassword
     * @return array
     */
    public function updateCurrentUserPassword(string $newPassword): array;

    /**
     * Обновляет фото пользователя
     *
     * @param UploadedFile $file
     * @return array
     */
    public function updateCurrentUserProfilePhoto(UploadedFile $file): array;

    /**
     * @param array $params
     * @return mixed
     */
    public function checkAndUpdateCurrentUserProfilePublished(array $params);

    /**
     * @param int $userId
     * @param array $params
     * @return mixed
     */
    public function checkAndUpdateUserProfilePublished(int $userId, array $params);

    /**
     * @param  int  $userId
     * @param  BaseValidator|null  $validator
     * @return Collection
     */
    public function checkUserDataCompleteness(int $userId, ?BaseValidator $validator = null): Collection;

    /**
     * Получает данные опубликованных электриков
     *
     * @return array
     */
    public function getPublishedElectrician(): array;

    /**
     * Удаляет текущего пользователя
     *
     * @return bool
     */
    public function deleteCurrentUser(): bool;

    /**
     * Удаляет пользователя
     *
     * @param int $userId
     * @return bool
     */
    public function deleteUser(int $userId): bool;

    /**
     * Записывает персональные данные пользователя
     * 
     * @param array $params
     * @return void
     */
    public function storePersonalData(array $params): void;
}
