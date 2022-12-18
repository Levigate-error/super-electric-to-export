<?php

namespace App\Domain\Repositories;

use Illuminate\Support\Collection;

/**
 * Interface ProductFamilyRepository
 * @package App\Domain\Repositories
 */
interface ProductFamilyRepository extends MustHaveGetSource
{
    /**
     * @param array $relations
     *
     * @return Collection
     */
    public function getAllByRelationIds(array $relations): Collection;
}
