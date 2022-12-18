<?php

namespace App\Services;

use App\Domain\ServiceContracts\CityServiceContract;
use App\Domain\Repositories\CityRepositoryContract;
use App\Http\Resources\CityResource;

/**
 * Class CityService
 * @package App\Services
 */
class CityService extends BaseService implements CityServiceContract
{
    /**
     * @var CityRepositoryContract
     */
    private $repository;

    /**
     * CityService constructor.
     * @param CityRepositoryContract $repository
     */
    public function __construct(CityRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return CityRepositoryContract
     */
    public function getRepository(): CityRepositoryContract
    {
        return $this->repository;
    }

    /**
     * @param array $params
     * @return array
     */
    public function search(array $params): array
    {
        $cities = $this->repository->getCitiesByParams($params);

        return CityResource::collection($cities->untype())->resolve();
    }
}
