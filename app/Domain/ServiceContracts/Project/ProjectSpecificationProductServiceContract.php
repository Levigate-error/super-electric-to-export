<?php

namespace App\Domain\ServiceContracts\Project;

use App\Domain\Repositories\Project\ProjectSpecificationProductRepository;
use App\Models\BaseModel;
use Illuminate\Support\Collection;

/**
 * Interface ProjectSpecificationProductServiceContract
 * @package App\Domain\ServiceContracts\Project
 */
interface ProjectSpecificationProductServiceContract
{
    /**
     * @return ProjectSpecificationProductRepository
     */
    public function getRepository(): ProjectSpecificationProductRepository;

    /**
     * @param ProjectSpecificationProductRepository $repository
     * @return mixed
     */
    public function setRepository(ProjectSpecificationProductRepository $repository);

    /**
     * @param int $specificationProductId
     * @return BaseModel
     */
    public function getSpecificationProduct(int $specificationProductId): BaseModel;

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
     * @param int $sectionId
     * @param int $productId
     * @return BaseModel|null
     */
    public function getSpecificationProductBySectionAndProduct(int $sectionId, int $productId): ?BaseModel;
}
