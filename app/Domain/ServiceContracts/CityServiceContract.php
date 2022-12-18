<?php

namespace App\Domain\ServiceContracts;

use App\Domain\Repositories\CityRepositoryContract;

/**
 * Interface CityServiceContract
 * @package App\Domain\ServiceContracts
 */
interface CityServiceContract
{
    /**
     * @return CityRepositoryContract
     */
    public function getRepository(): CityRepositoryContract;

    /**
     * @param array $params
     * @return array
     */
    public function search(array $params): array;
}
