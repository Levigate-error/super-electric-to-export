<?php

namespace App\Utils\ProductChangers\Resolvers\Drivers;

use App\Domain\ServiceContracts\Project\ProjectServiceContract;
use App\Domain\UtilContracts\ProductChangers\Resolvers\Contracts\ProjectProductChangesDriverContract;
use App\Models\Project\ProjectProductChange;
use App\Traits\ServiceGetter;

class RemovedDriver implements ProjectProductChangesDriverContract
{
    use ServiceGetter;

    /**
     * @param ProjectProductChange $projectProductChange
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function resolve(ProjectProductChange $projectProductChange): bool
    {
        if ($projectProductChange->used) {
            return false;
        }

        $projectService = $this->getService(ProjectServiceContract::class);
        if ($projectService->getRepository()->getSource()::deleteProductFromProject($projectProductChange->project_id, $projectProductChange->product_id)) {
            return $projectProductChange->setUsed();
        }

        return false;
    }
}
