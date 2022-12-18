<?php

namespace App\Domain\ServiceContracts;

use App\Domain\Repositories\ExternalEntityRepositoryContract;

/**
 * Interface ExternalEntityServiceContract
 * @package App\Domain\ServiceContracts
 */
interface ExternalEntityServiceContract
{
    /**
     * @return ExternalEntityRepositoryContract
     */
    public function getRepository(): ExternalEntityRepositoryContract;
}
