<?php

namespace App\Services;

use App\Domain\ServiceContracts\ExternalEntityServiceContract;
use App\Domain\Repositories\ExternalEntityRepositoryContract;

/**
 * Class ExternalEntityService
 * @package App\Services
 */
class ExternalEntityService extends BaseService implements ExternalEntityServiceContract
{
    /**
     * @var ExternalEntityRepositoryContract
     */
    private $repository;

    /**
     * ExternalEntityService constructor.
     * @param ExternalEntityRepositoryContract $repository
     */
    public function __construct(ExternalEntityRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return ExternalEntityRepositoryContract
     */
    public function getRepository(): ExternalEntityRepositoryContract
    {
        return $this->repository;
    }
}
