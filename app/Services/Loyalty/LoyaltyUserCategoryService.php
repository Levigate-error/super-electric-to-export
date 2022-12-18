<?php

namespace App\Services\Loyalty;

use App\Services\BaseService;
use App\Domain\ServiceContracts\Loyalty\LoyaltyUserCategoryServiceContract;
use App\Domain\Repositories\Loyalty\LoyaltyUserCategoryRepositoryContract;
use App\Http\Resources\Loyalty\LoyaltyUserCategoryResource;

/**
 * Class LoyaltyUserCategoryService
 * @package App\Services\Loyalty
 */
class LoyaltyUserCategoryService extends BaseService implements LoyaltyUserCategoryServiceContract
{
    /**
     * @var LoyaltyUserCategoryRepositoryContract
     */
    private $repository;

    /**
     * LoyaltyUserCategoryService constructor.
     * @param LoyaltyUserCategoryRepositoryContract $repository
     */
    public function __construct(LoyaltyUserCategoryRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return LoyaltyUserCategoryRepositoryContract
     */
    public function getRepository(): LoyaltyUserCategoryRepositoryContract
    {
        return $this->repository;
    }

    /**
     * @return array
     */
    public function getUserCategories(): array
    {
        $categories = $this->repository->getList();

        return LoyaltyUserCategoryResource::collection($categories->untype())->resolve();
    }

    /**
     * @param int $points
     * @return LoyaltyUserCategoryResource
     */
    public function getCategoryByPoints(int $points): LoyaltyUserCategoryResource
    {
        $userCategory = $this->repository->getCategoryByPoints($points);

        return LoyaltyUserCategoryResource::make($userCategory);
    }
}
