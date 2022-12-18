<?php

namespace App\Domain\Repositories\Project;

use App\Domain\Repositories\MustHaveGetSource;
use App\Models\Project\ProjectProductChange;

/**
 * Interface ProjectProductUpdateRepository
 * @package App\Domain\Repositories\Project
 */
interface ProjectProductUpdateRepository extends MustHaveGetSource
{
    /**
     * @param int $entityId
     * @return ProjectProductChange
     */
    public function getDetails(int $entityId): ProjectProductChange;
}
