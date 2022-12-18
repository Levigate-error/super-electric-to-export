<?php

namespace App\Services\Project;

use App\Services\BaseService;
use App\Domain\Repositories\Project\ProjectSpecificationSectionRepository;
use App\Domain\ServiceContracts\Project\ProjectSpecificationSectionServiceContract;
use App\Models\BaseModel;
use Illuminate\Support\Collection;

/**
 * Class ProjectSpecificationSectionService
 * @package App\Services
 */
class ProjectSpecificationSectionService extends BaseService implements ProjectSpecificationSectionServiceContract
{
    /**
     * @var ProjectSpecificationSectionRepository
     */
    private $repository;

    /**
     * ProjectSpecificationSectionService constructor.
     * @param ProjectSpecificationSectionRepository $repository
     */
    public function __construct(ProjectSpecificationSectionRepository $repository)
    {
        $this->setRepository($repository);

    }

    /**
     * @return ProjectSpecificationSectionRepository
     */
    public function getRepository(): ProjectSpecificationSectionRepository
    {
        return $this->repository;
    }

    /**
     * @param ProjectSpecificationSectionRepository $repository
     * @return mixed|void
     */
    public function setRepository(ProjectSpecificationSectionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $specificationSectionId
     * @return BaseModel
     */
    public function getSection(int $specificationSectionId): BaseModel
    {
        return $this->repository->getSection($specificationSectionId);
    }

    /**
     * @param int $sectionId
     * @param bool $activeOnly
     * @return Collection
     */
    public function getSectionProducts(int $sectionId, bool $activeOnly = false): Collection
    {
        return $this->repository->getSectionProducts($sectionId, $activeOnly);
    }
}
