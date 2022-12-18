<?php

namespace App\Services\Project;

use App\Services\BaseService;
use App\Domain\Repositories\Project\ProjectSpecificationProductRepository;
use App\Domain\ServiceContracts\Project\ProjectSpecificationProductServiceContract;
use App\Models\BaseModel;
use Illuminate\Support\Collection;

/**
 * Class ProjectSpecificationProductService
 * @package App\Services
 */
class ProjectSpecificationProductService extends BaseService implements ProjectSpecificationProductServiceContract
{
    /**
     * @var ProjectSpecificationProductRepository
     */
    private $repository;

    /**
     * ProjectSpecificationProductService constructor.
     * @param ProjectSpecificationProductRepository $repository
     */
    public function __construct(ProjectSpecificationProductRepository $repository)
    {
        $this->setRepository($repository);

    }

    /**
     * @return ProjectSpecificationProductRepository
     */
    public function getRepository(): ProjectSpecificationProductRepository
    {
        return $this->repository;
    }

    /**
     * @param ProjectSpecificationProductRepository $repository
     * @return mixed|void
     */
    public function setRepository(ProjectSpecificationProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $specificationProductId
     * @return BaseModel
     */
    public function getSpecificationProduct(int $specificationProductId): BaseModel
    {
        return $this->repository->getSpecificationProduct($specificationProductId);
    }

    /**
     * @param int $specificationId
     * @param int $productId
     * @return int
     */
    public function getUsedProductAmountInSpecification(int $specificationId, int $productId): int
    {
        return $this->repository->getUsedProductAmountInSpecification($specificationId, $productId);
    }

    /**
     * @param int $specificationId
     * @param int $productId
     * @return Collection
     */
    public function getSpecificationProductsByProduct(int $specificationId, int $productId): Collection
    {
        return $this->repository->getSpecificationProductsByProduct($specificationId, $productId);
    }

    /**
     * @param int $sectionId
     * @param int $productId
     * @return BaseModel|null
     */
    public function getSpecificationProductBySectionAndProduct(int $sectionId, int $productId): ?BaseModel
    {
        return $this->repository->getSpecificationProductBySectionAndProduct($sectionId, $productId);
    }
}
