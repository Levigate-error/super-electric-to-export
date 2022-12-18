<?php

namespace App\Domain\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Interface FaqRepositoryContract
 * @package App\Domain\Repositories
 */
interface FaqRepositoryContract extends MustHaveGetSource
{
    /**
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function getByParams(array $params = []): LengthAwarePaginator;
}
