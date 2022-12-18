<?php

namespace App\Domain\UtilContracts\ProductChangers\Resolvers\Contracts;

use App\Models\Project\ProjectProductChange;

/**
 * Interface ProjectProductChangesDriverContract
 * @package App\Domain\UtilContracts\ProductChangers\Resolvers\Contracts
 */
interface ProjectProductChangesDriverContract
{
    /**
     * Процесс принятия измения в товаре проекта
     *
     * @param ProjectProductChange $projectProductChange
     * @return bool
     */
    public function resolve(ProjectProductChange $projectProductChange): bool;
}
