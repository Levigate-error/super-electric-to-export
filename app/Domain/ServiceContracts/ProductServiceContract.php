<?php

namespace App\Domain\ServiceContracts;

use App\Domain\Repositories\ProductRepository;
use App\Http\Resources\ProductDetailResource;

/**
 * Interface ProductServiceContract
 * @package App\Domain\ServiceContracts
 */
interface ProductServiceContract
{
    /**
     * @return ProductRepository
     */
    public function getRepository(): ProductRepository;

    /**
     * @param ProductRepository $repository
     */
    public function setRepository(ProductRepository $repository);

    /**
     * @param array $params
     *
     * @return mixed
     */
    public function getProductsByParams(array $params = []);

    /**
     * @param int $productId
     *
     * @return mixed
     */
    public function getProductDetails(int $productId): ProductDetailResource;

    /**
     * @param array $where
     * @return ProductDetailResource|null
     */
    public function getProductByParam(array $where): ?ProductDetailResource;

    /**
     * @return array
     */
    public function getRecommendedProducts(): array;

    /**
     * @param int $productId
     * @return array
     */
    public function getBuyWithItProducts(int $productId): array;
}
