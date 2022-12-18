<?php

namespace App\Domain\ServiceContracts;

use App\Domain\Repositories\FaqRepositoryContract;

/**
 * Interface FaqServiceContract
 * @package App\Domain\ServiceContracts
 */
interface FaqServiceContract
{
    /**
     * @return FaqRepositoryContract
     */
    public function getRepository(): FaqRepositoryContract;

    /**
     * @param array $params
     * @return array
     */
    public function getFaqsByParams(array $params = []): array;
}
