<?php

namespace App\Domain\Repositories\Log;

use App\Collections\Log\CreateLogCollection;
use App\Domain\Repositories\MustHaveGetSource;

/**
 * Interface CreateLogRepositoryContract
 * @package App\Domain\Repositories\Log
 */
interface CreateLogRepositoryContract extends MustHaveGetSource
{
    /**
     * @param array $params
     * @return CreateLogCollection
     */
    public function getByParams(array $params = []): CreateLogCollection;
}
