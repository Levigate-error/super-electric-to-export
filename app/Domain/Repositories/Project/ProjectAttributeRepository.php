<?php

namespace App\Domain\Repositories\Project;

use App\Domain\Repositories\MustHaveGetSource;
use Illuminate\Support\Collection;

/**
 * Interface ProjectAttributeRepository
 * @package App\Domain\Repositories\Project
 */
interface ProjectAttributeRepository extends MustHaveGetSource
{
    /**
     * @return Collection
     */
    public function getAll(): Collection;
}
