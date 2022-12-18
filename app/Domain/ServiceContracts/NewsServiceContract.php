<?php

namespace App\Domain\ServiceContracts;

use App\Domain\Repositories\NewsRepositoryContract;

/**
 * Interface NewsServiceContract
 * @package App\Domain\ServiceContracts
 */
interface NewsServiceContract
{
    /**
     * @return NewsRepositoryContract
     */
    public function getRepository(): NewsRepositoryContract;

    /**
     * @param array $params
     * @return array
     */
    public function getNewsByParams(array $params = []): array;

    /**
     * @param int $newsId
     * @return array
     */
    public function getNewsDetails(int $newsId): array;
}
