<?php

namespace App\Domain\Repositories;

use App\Collections\BannerCollection;

/**
 * Interface BannerRepositoryContract
 * @package App\Domain\Repositories
 */
interface BannerRepositoryContract extends MustHaveGetSource
{
    /**
     * @param array $params
     * @return BannerCollection
     */
    public function getListByParams(array $params): BannerCollection;
}
