<?php

namespace App\Domain\Repositories\Project;

use App\Domain\Repositories\MustHaveGetSource;
use App\Models\BaseModel;
use Illuminate\Support\Collection;

/**
 * Interface ProjectSpecificationProductRepository
 * @package App\Domain\Repositories\Project
 */
interface ProjectSpecificationProductRepository extends MustHaveGetSource
{
    /**
     * @param int $specificationId
     * @return BaseModel
     */
    public function getSpecificationProduct(int $specificationId): BaseModel;

    /**
     * @param int $specificationId
     * @param int $productId
     * @return int
     */
    public function getUsedProductAmountInSpecification(int $specificationId, int $productId): int;

    /**
     * @param int $specificationId
     * @param int $productId
     * @return Collection
     */
    public function getSpecificationProductsByProduct(int $specificationId, int $productId): Collection;

    /**
     * @param $sectionId
     * @param $productId
     * @return BaseModel|null
     */
    public function getSpecificationProductBySectionAndProduct($sectionId, $productId): ?BaseModel;

    /**
     * Товары внтури спецификации и проекта
     *
     * @param int $projectId
     * @param int $specificationId
     * @return Collection
     */
    public function getProjectSpecificationProducts(int $projectId, int $specificationId): Collection;
}
