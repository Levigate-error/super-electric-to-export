<?php

namespace App\Domain\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Interface NewsRepositoryContract
 * @package App\Domain\Repositories
 */
interface NewsRepositoryContract extends MustHaveGetSource
{
    /**
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function getByParams(array $params = []): LengthAwarePaginator;
}
