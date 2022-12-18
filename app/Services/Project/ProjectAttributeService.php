<?php

namespace App\Services\Project;

use App\Services\BaseService;
use App\Domain\Repositories\Project\ProjectAttributeRepository;
use App\Domain\ServiceContracts\Project\ProjectAttributeServiceContract;
use App\Http\Resources\Project\ProjectAttributeResource;

/**
 * Class ProjectAttributeService
 * @package App\Services
 */
class ProjectAttributeService extends BaseService implements ProjectAttributeServiceContract
{
    /**
     * @var ProjectAttributeRepository
     */
    private $repository;

    /**
     * ProjectAttributeService constructor.
     * @param ProjectAttributeRepository $repository
     */
    public function __construct(ProjectAttributeRepository $repository)
    {
        $this->setRepository($repository);
    }

    /**
     * @return ProjectAttributeRepository
     */
    public function getRepository(): ProjectAttributeRepository
    {
        return $this->repository;
    }

    /**
     * @param ProjectAttributeRepository $repository
     */
    public function setRepository(ProjectAttributeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function getAttributesList(): array
    {
        $attributes = $this->repository->getAll();

        return ProjectAttributeResource::collection($attributes)->resolve();
    }
}
