<?php

namespace App\Domain\ServiceContracts\Project;

use App\Domain\Repositories\Project\ProjectSpecificationSectionRepository;
use App\Models\BaseModel;
use Illuminate\Support\Collection;

/**
 * Interface ProjectSpecificationSectionServiceContract
 * @package App\Domain\ServiceContracts\Project
 */
interface ProjectSpecificationSectionServiceContract
{
    /**
     * @return ProjectSpecificationSectionRepository
     */
    public function getRepository(): ProjectSpecificationSectionRepository;

    /**
     * @param ProjectSpecificationSectionRepository $repository
     * @return mixed
     */
    public function setRepository(ProjectSpecificationSectionRepository $repository);

    /**
     * @param int $specificationSectionId
     * @return BaseModel
     */
    public function getSection(int $specificationSectionId): BaseModel;

    /**
     * @param int $sectionId
     * @param bool $activeOnly
     * @return Collection
     */
    public function getSectionProducts(int $sectionId, bool $activeOnly = false): Collection;
}
