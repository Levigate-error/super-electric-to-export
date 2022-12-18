<?php

namespace App\Repositories\Project;

use App\Models\Project\ProjectStatus;
use App\Domain\Repositories\Project\ProjectStatusRepository;
use Illuminate\Support\Collection;
use App\Traits\HasSourceGetter;

/**
 * Class ProjectStatusEloquentRepository
 * @package App\Repositories\Project
 */
class ProjectStatusEloquentRepository implements ProjectStatusRepository
{
    use HasSourceGetter;

    /**
     * @var string
     */
    private $source = ProjectStatus::class;

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->getSource()::get();
    }
}
