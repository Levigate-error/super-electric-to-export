<?php

namespace App\Services\Log;

use App\Services\BaseService;
use App\Domain\ServiceContracts\Log\CreateLogServiceContract;
use App\Domain\Repositories\Log\CreateLogRepositoryContract;

/**
 * Class CreateLogService
 * @package App\Services\Log
 */
class CreateLogService extends BaseService implements CreateLogServiceContract
{
    /**
     * @var CreateLogRepositoryContract
     */
    private $repository;

    /**
     * CreateLogService constructor.
     * @param CreateLogRepositoryContract $repository
     */
    public function __construct(CreateLogRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return CreateLogRepositoryContract
     */
    public function getRepository(): CreateLogRepositoryContract
    {
        return $this->repository;
    }

    /**
     * @param string $client
     * @param string $type
     * @param string|null $dateFrom
     * @return int
     */
    public function getCreatedCount(string $client, string $type, ?string $dateFrom = null): int
    {
        $createdLogs = $this->repository->getByParams([
            'client' => $client,
            'type' => $type,
            'dateFrom' => $dateFrom,
        ]);

        return $createdLogs->count();
    }
}
