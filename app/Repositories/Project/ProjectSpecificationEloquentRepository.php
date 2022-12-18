<?php

namespace App\Repositories\Project;

use App\Models\BaseModel;
use App\Models\Project\ProjectSpecification;
use App\Domain\Repositories\Project\ProjectSpecificationRepository;
use Illuminate\Support\Collection;
use App\Traits\HasSourceGetter;

/**
 * Class ProjectSpecificationEloquentRepository
 * @package App\Repositories\Project
 */
class ProjectSpecificationEloquentRepository implements ProjectSpecificationRepository
{
    use HasSourceGetter;

    /**
     * @var string
     */
    private $source = ProjectSpecification::class;

    /**
     * @param int $specificationId
     * @param bool $activeOnly
     * @return Collection
     */
    public function getSpecificationSections(int $specificationId, bool $activeOnly = false): Collection
    {
        $specification = $this->getSource()::query()->findOrFail($specificationId);

        if ($activeOnly) {
            return $specification->specificationSections()->active()->get();
        }

        return $specification->specificationSections;
    }

    /**
     * @param int $specificationId
     * @return BaseModel
     */
    public function getSpecification(int $specificationId): BaseModel
    {
        return $this->getSource()::query()->findOrFail($specificationId);
    }

    /**
     * @param int $specificationId
     * @param int $sectionId
     * @return BaseModel
     */
    public function getSpecificationSection(int $specificationId, int $sectionId): BaseModel
    {
        $specification = $this->getSource()::query()->findOrFail($specificationId);

        return $specification->specificationSections()->findOrFail($sectionId);
    }

    /**
     * @param int $specificationId
     * @return BaseModel
     */
    public function getProjectBySpecification(int $specificationId): BaseModel
    {
        $specification = $this->getSpecification($specificationId);

        return $specification->project;
    }
}
