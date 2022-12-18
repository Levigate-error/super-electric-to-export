<?php

namespace App\Repositories\Project;

use App\Models\Project\ProjectProductChange;
use App\Models\BaseModel;
use App\Domain\Repositories\Project\ProjectProductUpdateRepository;
use App\Traits\HasSourceGetter;

/**
 * Class ProjectProductUpdateEloquentRepository
 * @package App\Repositories\Project
 */
class ProjectProductUpdateEloquentRepository implements ProjectProductUpdateRepository
{
    use HasSourceGetter;

    /**
     * @var string
     */
    private $source = ProjectProductChange::class;

    /**
     * @param int $entityId
     * @return ProjectProductChange
     */
    public function getDetails(int $entityId): ProjectProductChange
    {
        return $this->getSource()::query()->findOrFail($entityId);
    }
}
