<?php

namespace App\Observers;

use App\Domain\ServiceContracts\Project\ProjectServiceContract;
use App\Models\Project\ProjectSpecificationProduct;

/**
 * Class ProjectSpecificationProductsObserver
 * @package App\Observers
 */
class ProjectSpecificationProductsObserver
{
    /**
     * @var ProjectServiceContract
     */
    private $service;

    /**
     * ProjectSpecificationProductsObserver constructor.
     * @param ProjectServiceContract $service
     */
    public function __construct(ProjectServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the project specification product "created" event.
     *
     * @param  ProjectSpecificationProduct  $projectSpecificationProduct
     * @return void
     */
    public function created(ProjectSpecificationProduct $projectSpecificationProduct): void
    {
        $project = $projectSpecificationProduct->specificationSection->specification->project;

        $this->service->reCalcProject($project->id);
    }

    /**
     * Handle the project specification product "updated" event.
     *
     * @param  ProjectSpecificationProduct  $projectSpecificationProduct
     * @return void
     */
    public function updated(ProjectSpecificationProduct $projectSpecificationProduct): void
    {
        $project = $projectSpecificationProduct->specificationSection->specification->project;

        $this->service->reCalcProject($project->id);
    }

    /**
     * Handle the project specification product "deleted" event.
     *
     * @param  ProjectSpecificationProduct  $projectSpecificationProduct
     * @return void
     */
    public function deleted(ProjectSpecificationProduct $projectSpecificationProduct): void
    {
        $project = $projectSpecificationProduct->specificationSection->specification->project;

        $this->service->reCalcProject($project->id);
    }
}
