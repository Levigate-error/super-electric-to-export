<?php

namespace App\Domain\Repositories;

use Illuminate\Support\Collection;

/**
 * Interface ProductDivisionRepository
 * @package App\Domain\Repositories
 */
interface ProductDivisionRepository extends MustHaveGetSource
{
    /**
     * @param array $relations
     *
     * @return Collection
     */
    public function getAllByRelationIds(array $relations): Collection;
}
