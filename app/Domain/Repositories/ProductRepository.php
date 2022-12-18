<?php

namespace App\Domain\Repositories;

use App\Models\BaseModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface ProductRepository
 * @package App\Domain\Repositories
 */
interface ProductRepository extends MustHaveGetSource
{
    /**
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function getProductsByParams(array $params = []): LengthAwarePaginator;

    /**
     * @param int $productId
     *
     * @return mixed
     */
    public function getProductDetails(int $productId): BaseModel;

    /**
     * @param array $where
     * @return BaseModel|null
     */
    public function getProductByParam(array $where): ?BaseModel;

    /**
     * @return Collection
     */
    public function getRecommendedProducts(): Collection;

    /**
     * @param int $productId
     * @return Collection
     */
    public function getBuyWithItProducts(int $productId): Collection;
}
