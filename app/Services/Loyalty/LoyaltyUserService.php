<?php

namespace App\Services\Loyalty;

use App\Services\BaseService;
use App\Domain\ServiceContracts\Loyalty\LoyaltyUserServiceContract;
use App\Domain\ServiceContracts\Loyalty\LoyaltyUserCategoryServiceContract;
use App\Domain\Repositories\Loyalty\LoyaltyUserRepositoryContract;
use App\Http\Resources\Loyalty\LoyaltyUserResource;
use Illuminate\Support\Facades\Auth;
use App\Domain\Dictionaries\Loyalty\LoyaltyUserStatuses;

/**
 * Class LoyaltyUserService
 * @package App\Services\Loyalty
 */
class LoyaltyUserService extends BaseService implements LoyaltyUserServiceContract
{
    /**
     * @var LoyaltyUserRepositoryContract
     */
    private $repository;

    /**
     * @var LoyaltyUserCategoryServiceContract
     */
    private $userCategoryService;

    /**
     * LoyaltyUserService constructor.
     * @param LoyaltyUserRepositoryContract $repository
     * @param LoyaltyUserCategoryServiceContract $userCategoryService
     */
    public function __construct(LoyaltyUserRepositoryContract $repository,
                                LoyaltyUserCategoryServiceContract $userCategoryService)
    {
        $this->repository = $repository;
        $this->userCategoryService = $userCategoryService;
    }

    /**
     * @return LoyaltyUserRepositoryContract
     */
    public function getRepository(): LoyaltyUserRepositoryContract
    {
        return $this->repository;
    }

    /**
     * @param array $params
     * @return LoyaltyUserResource
     */
    public function getFirstLoyaltyUserByParams(array $params): LoyaltyUserResource
    {
        $loyaltyUsers = $this->repository->getLoyaltyUsersByParams($params);

        return LoyaltyUserResource::make($loyaltyUsers->first());
    }

    /**
     * @param int $loyaltyId
     * @param int $userId
     * @return LoyaltyUserResource
     */
    private function getUserRegister(int $loyaltyId, int $userId): LoyaltyUserResource
    {
        return $this->getFirstLoyaltyUserByParams([
            'loyalty_id' => $loyaltyId,
            'user_id' => $userId,
        ]);
    }

    /**
     * @param int $loyaltyId
     * @param int $userId
     * @return bool
     */
    public function checkSameRegister(int $loyaltyId, int $userId): bool
    {
        $userLoyalty = $this->getUserRegister($loyaltyId, $userId);

        if ($userLoyalty->resource === null) {
            return false;
        }

        return true;
    }

    /**
     * @param int $loyaltyId
     * @param int $userId
     * @param int $certificateId
     * @return LoyaltyUserResource
     */
    public function registerUser(int $loyaltyId, int $userId, int $certificateId): LoyaltyUserResource
    {
        $loyaltyUser = $this->repository->getSource()::registerUser($loyaltyId, $userId, $certificateId);

        return LoyaltyUserResource::make($loyaltyUser);
    }

    /**
     * @param int $loyaltyId
     * @param int $userId
     * @return bool
     */
    public function checkRegisterCodeAbility(int $loyaltyId, int $userId): bool
    {
        return $this->checkUserRegisterInLoyalty($loyaltyId, $userId);
    }

    /**
     * @param int $loyaltyId
     * @param int $userId
     * @return bool
     */
    public function checkUserRegisterInLoyalty(int $loyaltyId, int $userId): bool
    {
        $userLoyalty = $this->getUserRegister($loyaltyId, $userId);

        if ($userLoyalty->resource === null || $userLoyalty->resource->status === LoyaltyUserStatuses::CANCELED) {
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function getCurrentUserLoyalties(): array
    {
        if (Auth::user() === null) {
            return [];
        }

        $userLoyalties = $this->repository->getLoyaltyUsersByParams([
            'user_id' => Auth::user()->id,
        ]);

        return LoyaltyUserResource::collection($userLoyalties->untype())->resolve();
    }

    /**
     * @param int $loyaltyUserId
     * @return bool
     */
    public function setUserCategory(int $loyaltyUserId): bool
    {
        $loyaltyUser = $this->repository->getById($loyaltyUserId);

        $category = $this->userCategoryService->getCategoryByPoints($loyaltyUser->loyaltyUserPoint->points);

        if ($category->resource === null) {
            return false;
        }

        return $this->repository->getSource()::setUserCategory($loyaltyUserId, $category->resource->id);
    }

    public function getInspiriaLoyaltyUserByParams(array $params)
    {
        return $this->repository->getSource()::firstOrCreate($params, ['status' => LoyaltyUserStatuses::NEW]);
    }
    
    public function getFirstLoyaltyUserOrRegisterByParams(int $loyaltyId, int $userId)
    {
        return $this->repository->getSource()::firstOrCreateUser($loyaltyId, $userId, null);
    }
}
