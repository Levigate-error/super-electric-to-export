<?php

namespace App\Domain\Repositories;

use Illuminate\Support\Collection;
use App\Models\ProductFeatureValue;

/**
 * Interface ProductFeatureRepository
 * @package App\Domain\Repositories
 */
interface ProductFeatureRepository
{
    /**
     * @param array $params
     *
     * @return Collection
     */
    public function getFiltersByParams(array $params = []): Collection;

    /**
     * @param ProductFeatureValue $model
     * @param array               $params
     *
     * @return int
     */
    public function getFeatureValueProductCountByParams(ProductFeatureValue $model, array $params): int;
}
