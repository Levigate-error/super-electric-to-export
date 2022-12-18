<?php

namespace App\Observers;

use App\Models\Project\ProjectProduct;
use App\Domain\ServiceContracts\Project\ProjectServiceContract;
use App\Traits\HasCache;

/**
 * Class ProjectProductObserver
 * @package App\Observers
 */
class ProjectProductObserver
{
    use HasCache;

    /**
     * @var ProjectServiceContract
     */
    private $projectService;

    /**
     * ProjectProductObserver constructor.
     * @param ProjectServiceContract $projectService
     */
    public function __construct(ProjectServiceContract $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * @param ProjectProduct $projectProduct
     */
    public function created(ProjectProduct $projectProduct): void
    {
        $projectProduct->updatePriceWithDiscount();

        $projectProduct->product->incrementRank();
        $this->clearProductsCache();

        $this->projectService->reCalcProject($projectProduct->project_id);
    }

    /**
     * @param ProjectProduct $projectProduct
     */
    public function updated(ProjectProduct $projectProduct): void
    {
        $projectProduct->updatePriceWithDiscount();

        $this->projectService->updateProjectSpecificationProduct($projectProduct->project_id, $projectProduct->product_id);

        $this->projectService->reCalcProject($projectProduct->project_id);
    }

    /**
     * @param ProjectProduct $projectProduct
     */
    public function deleted(ProjectProduct $projectProduct): void
    {
        $this->projectService->reCalcProject($projectProduct->project_id);
    }
}
