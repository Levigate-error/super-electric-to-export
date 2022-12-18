<?php

namespace App\Observers;

use App\Models\Project\ProjectSpecification;

/**
 * Class ProjectSpecificationObserver
 * @package App\Observers
 */
class ProjectSpecificationObserver
{
    /**
     * @param ProjectSpecification $specification
     */
    public function creating(ProjectSpecification $specification): void
    {
        $specification->setVersion();
    }
}
