<?php

namespace App\Domain\Repositories\Project;

use App\Collections\Product\ProductCollection;
use App\Collections\ProjectCollection;
use App\Domain\Repositories\MustHaveGetSource;
use App\Models\BaseModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Interface ProjectRepository
 * @package App\Domain\Repositories\Project
 */
interface ProjectRepository extends MustHaveGetSource
{
    /**
     * @param int $projectId
     * @return mixed
     */
    public function getProjectDetails(int $projectId);

    /**
     * @param int $limit
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function getProjectsByParams(int $limit, array $params = []): LengthAwarePaginator;

    /**
     * @param int $projectId
     * @return Collection
     */
    public function getProjectCategories(int $projectId): Collection;

    /**
     * @param int $projectId
     * @param int $productDivisionId
     * @return int
     */
    public function getProductAmountInDivision(int $projectId, int $productDivisionId): int;

    /**
     * @param int $projectId
     * @param int $productDivisionId
     * @return Collection
     */
    public function getProjectAndDivisionProducts(int $projectId, int $productDivisionId): Collection;

    /**
     * @param int $projectId
     * @param array $params
     * @return Collection
     */
    public function getProjectProductsByParams(int $projectId, array $params = []): Collection;

    /**
     * @param int $projectId
     * @return BaseModel|null
     */
    public function getProjectSpecifications(int $projectId): ?BaseModel;

    /**
     * @param int $projectId
     * @param bool $activeOnly
     * @return Collection
     */
    public function getNotUsedProducts(int $projectId, bool $activeOnly = false): Collection;

    /**
     * @param int $projectId
     * @param int $productId
     * @param bool $withException
     * @return BaseModel|null
     */
    public function getProjectProduct(int $projectId, int $productId, bool $withException = true): ?BaseModel;

    /**
     * @param int $specificationId
     * @param int $specificationProductId
     * @return BaseModel
     */
    public function getProjectBySpecificationAndSpecificationProduct(int $specificationId, int $specificationProductId): BaseModel;

    /**
     * @param int $projectId
     * @param int $productId
     * @return int
     */
    public function getProjectProductUsedAmount(int $projectId, int $productId): int;

    /**
     * @param string $session
     * @return ProjectCollection
     */
    public function getProjectsBySession(string $session): ProjectCollection;

    /**
     * @param int $projectId
     * @param int $categoryId
     * @return ProductCollection
     */
    public function getProjectAndCategoryProducts(int $projectId, int $categoryId): ProductCollection;
}
