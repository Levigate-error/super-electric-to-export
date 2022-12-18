<?php

namespace App\Domain\Repositories\Project;

use App\Domain\Repositories\MustHaveGetSource;
use App\Models\BaseModel;
use Illuminate\Support\Collection;

/**
 * Interface ProjectSpecificationSectionRepository
 * @package App\Domain\Repositories\Project
 */
interface ProjectSpecificationSectionRepository extends MustHaveGetSource
{
    /**
     * @param int $sectionId
     * @return BaseModel
     */
    public function getSection(int $sectionId): BaseModel;

    /**
     * @param int $sectionId
     * @param bool $activeOnly
     * @return Collection
     */
    public function getSectionProducts(int $sectionId, bool $activeOnly = false): Collection;
}
