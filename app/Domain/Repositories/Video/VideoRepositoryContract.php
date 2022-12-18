<?php

namespace App\Domain\Repositories\Video;

use App\Domain\Repositories\MustHaveGetSource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Interface VideoRepositoryContract
 * @package App\Domain\Repositories\Video
 */
interface VideoRepositoryContract extends MustHaveGetSource
{
    /**
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function getByParams(array $params = []): LengthAwarePaginator;
}
