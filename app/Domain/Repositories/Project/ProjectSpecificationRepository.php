<?php

namespace App\Domain\Repositories\Project;

use App\Domain\Repositories\MustHaveGetSource;
use App\Models\BaseModel;
use Illuminate\Support\Collection;

/**
 * Interface ProjectSpecificationRepository
 * @package App\Domain\Repositories\Project
 */
interface ProjectSpecificationRepository extends MustHaveGetSource
{
    /**
     * @param int $specificationId
     * @param bool $activeOnly
     * @return Collection
     */
    public function getSpecificationSections(int $specificationId, bool $activeOnly = false): Collection;

    /**
     * @param int $specificationId
     * @return BaseModel
     */
    public function getSpecification(int $specificationId): BaseModel;

    /**
     * @param int $specificationId
     * @param int $sectionId
     * @return BaseModel
     */
    public function getSpecificationSection(int $specificationId, int $sectionId): BaseModel;

    /**
     * @param int $specificationId
     * @return BaseModel
     */
    public function getProjectBySpecification(int $specificationId): BaseModel;
}
