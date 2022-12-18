<?php

namespace App\Rules;

use App\Domain\ServiceContracts\Project\ProjectServiceContract;
use App\Domain\Repositories\Project\ProjectRepository;
use Illuminate\Contracts\Validation\Rule;

class ProjectProductRule implements Rule
{
    /**
     * @var ProjectServiceContract
     */
    private $service;

    /**
     * @var ProjectRepository
     */
    private $repository;

    /**
     * ProjectProductRule constructor.
     * @param ProjectServiceContract $service
     */
    public function __construct(ProjectServiceContract $service)
    {
        $this->service = $service;
        $this->repository = $service->getRepository();
    }

    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $source = $this->repository->getSource();

        foreach ($value as $productProject) {
            $project = $source::query()->findOrFail($productProject['project']);

            if (!$project->checkOwnerPermission()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return __('project.validation.no-owner');
    }
}
