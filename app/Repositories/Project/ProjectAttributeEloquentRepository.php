<?php

namespace App\Repositories\Project;

use App\Models\Project\ProjectAttribute;
use App\Domain\Repositories\Project\ProjectAttributeRepository;
use Illuminate\Support\Collection;
use App\Traits\HasSourceGetter;

/**
 * Class ProjectAttributeEloquentRepository
 * @package App\Repositories\Project
 */
class ProjectAttributeEloquentRepository implements ProjectAttributeRepository
{
    use HasSourceGetter;

    /**
     * @var string
     */
    private $source = ProjectAttribute::class;

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->getSource()::get();
    }
}
