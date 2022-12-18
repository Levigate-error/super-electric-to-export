<?php

namespace App\Repositories\Project;

use App\Models\BaseModel;
use App\Models\Project\ProjectSpecificationSection;
use App\Domain\Repositories\Project\ProjectSpecificationSectionRepository;
use Illuminate\Support\Collection;
use App\Traits\HasSourceGetter;

/**
 * Class ProjectSpecificationSectionEloquentRepository
 * @package App\Repositories\Project
 */
class ProjectSpecificationSectionEloquentRepository implements ProjectSpecificationSectionRepository
{
    use HasSourceGetter;

    /**
     * @var string
     */
    private $source = ProjectSpecificationSection::class;

    /**
     * @param int $sectionId
     * @return BaseModel
     */
    public function getSection(int $sectionId): BaseModel
    {
        return $this->getSource()::query()->findOrFail($sectionId);
    }

    /**
     * @param int $sectionId
     * @param bool $activeOnly
     * @return Collection
     */
    public function getSectionProducts(int $sectionId, bool $activeOnly = false): Collection
    {
        $section = $this->getSection($sectionId);

        if ($activeOnly) {
            return $section->products()->active()->get();
        }

        return $section->products;
    }
}
