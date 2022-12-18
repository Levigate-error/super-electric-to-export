<?php

namespace App\Domain\ServiceContracts\Log;

use App\Domain\Repositories\Log\CreateLogRepositoryContract;

/**
 * Interface CreateLogServiceContract
 * @package App\Domain\ServiceContracts\Log
 */
interface CreateLogServiceContract
{
    /**
     * @return CreateLogRepositoryContract
     */
    public function getRepository(): CreateLogRepositoryContract;

    /**
     * @param string $client
     * @param string $type
     * @param string|null $dateFrom
     * @return int
     */
    public function getCreatedCount(string $client, string $type, ?string $dateFrom = null): int;
}
