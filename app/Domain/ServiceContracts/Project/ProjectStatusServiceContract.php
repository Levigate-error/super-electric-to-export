<?php

namespace App\Domain\ServiceContracts\Project;

use App\Domain\Repositories\Project\ProjectStatusRepository;

/**
 * Interface ProjectStatusServiceContract
 * @package App\Domain\ServiceContracts\Project
 */
interface ProjectStatusServiceContract
{
    /**
     * @return ProjectStatusRepository
     */
    public function getRepository(): ProjectStatusRepository;

    /**
     * @param ProjectStatusRepository $repository
     * @return mixed
     */
    public function setRepository(ProjectStatusRepository $repository);

    /**
     * @return array
     */
    public function getStatusesList(): array;
}
