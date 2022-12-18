<?php

namespace App\Domain\Repositories;

use App\Collections\CityCollection;

/**
 * Interface CityRepositoryContract
 * @package App\Domain\Repositories
 */
interface CityRepositoryContract extends MustHaveGetSource
{
    /**
     * @param array $params
     * @return CityCollection
     */
    public function getCitiesByParams(array $params): CityCollection;
}
