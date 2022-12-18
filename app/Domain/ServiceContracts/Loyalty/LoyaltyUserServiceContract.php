<?php

namespace App\Domain\ServiceContracts\Loyalty;

use App\Domain\Repositories\Loyalty\LoyaltyUserRepositoryContract;
use App\Http\Resources\Loyalty\LoyaltyUserResource;

/**
 * Interface LoyaltyUserServiceContract
 * @package App\Domain\ServiceContracts\Loyalty
 */
interface LoyaltyUserServiceContract
{
    /**
     * @return LoyaltyUserRepositoryContract
     */
    public function getRepository(): LoyaltyUserRepositoryContract;

    /**
     * @param array $params
     * @return LoyaltyUserResource
     */
    public function getFirstLoyaltyUserByParams(array $params): LoyaltyUserResource;

    /**
     * @param int $loyaltyId
     * @param int $userId
     * @return bool
     */
    public function checkSameRegister(int $loyaltyId, int $userId): bool;

    /**
     * @param int $loyaltyId
     * @param int $userId
     * @param int $certificateId
     * @return LoyaltyUserResource
     */
    public function registerUser(int $loyaltyId, int $userId, int $certificateId): LoyaltyUserResource;

    /**
     * @param int $loyaltyId
     * @param int $userId
     * @return bool
     */
    public function checkRegisterCodeAbility(int $loyaltyId, int $userId): bool;

    /**
     * @param int $loyaltyId
     * @param int $userId
     * @return bool
     */
    public function checkUserRegisterInLoyalty(int $loyaltyId, int $userId): bool;

    /**
     * @return array
     */
    public function getCurrentUserLoyalties(): array;

    /**
     * @param int $loyaltyUserId
     * @return bool
     */
    public function setUserCategory(int $loyaltyUserId): bool;
}
