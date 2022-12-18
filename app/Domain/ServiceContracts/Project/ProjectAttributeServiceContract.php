<?php

namespace App\Domain\ServiceContracts\Project;

use App\Domain\Repositories\Project\ProjectAttributeRepository;

/**
 * Interface ProjectAttributeServiceContract
 * @package App\Domain\ServiceContracts\Project
 */
interface ProjectAttributeServiceContract
{
    /**
     * @return ProjectAttributeRepository
     */
    public function getRepository(): ProjectAttributeRepository;

    /**
     * @param ProjectAttributeRepository $repository
     * @return mixed
     */
    public function setRepository(ProjectAttributeRepository $repository);

    /**
     * @return array
     */
    public function getAttributesList(): array;
}
