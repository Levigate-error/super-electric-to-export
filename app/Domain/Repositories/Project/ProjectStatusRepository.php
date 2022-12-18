<?php

namespace App\Domain\Repositories\Project;

use App\Domain\Repositories\MustHaveGetSource;
use Illuminate\Support\Collection;

/**
 * Interface ProjectStatusRepository
 * @package App\Domain\Repositories\Project
 */
interface ProjectStatusRepository extends MustHaveGetSource
{
    /**
     * @return Collection
     */
    public function getAll(): Collection;
}
