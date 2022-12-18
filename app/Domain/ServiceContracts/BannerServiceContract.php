<?php

namespace App\Domain\ServiceContracts;

use App\Domain\Repositories\BannerRepositoryContract;

/**
 * Interface BannerServiceContract
 * @package App\Domain\ServiceContracts
 */
interface BannerServiceContract
{
    /**
     * @return BannerRepositoryContract
     */
    public function getRepository(): BannerRepositoryContract;

    /**
     * @return array
     */
    public function getListForCurrentUser(): array;

    /**
     * @param array $params
     * @return array
     */
    public function getListByParams(array $params): array;
}
