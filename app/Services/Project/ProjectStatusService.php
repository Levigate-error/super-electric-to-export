<?php

namespace App\Services\Project;

use App\Services\BaseService;
use App\Domain\Repositories\Project\ProjectStatusRepository;
use App\Domain\ServiceContracts\Project\ProjectStatusServiceContract;
use App\Http\Resources\Project\ProjectStatusResource;

/**
 * Class ProjectAttributeService
 * @package App\Services
 */
class ProjectStatusService extends BaseService implements ProjectStatusServiceContract
{
    /**
     * @var ProjectStatusRepository
     */
    private $repository;

    /**
     * ProjectStatusService constructor.
     * @param ProjectStatusRepository $repository
     */
    public function __construct(ProjectStatusRepository $repository)
    {
        $this->setRepository($repository);
    }

    /**
     * @return ProjectStatusRepository
     */
    public function getRepository(): ProjectStatusRepository
    {
        return $this->repository;
    }

    /**
     * @param ProjectStatusRepository $repository
     * @return mixed|void
     */
    public function setRepository(ProjectStatusRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function getStatusesList(): array
    {
        $statuses = $this->repository->getAll();

        return ProjectStatusResource::collection($statuses)->resolve();
    }
}
