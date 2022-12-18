<?php

namespace App\Services;

use App\Http\Resources\ProductCategoryResource;
use App\Domain\ServiceContracts\ProductCategoryServiceContract;
use App\Domain\Repositories\ProductCategoryRepository;
use Illuminate\Support\Facades\Cache;
use App\Domain\Dictionaries\Cache\ProductCategoryCache;

/**
 * Class ProductCategoryService
 * @package App\Services
 */
class ProductCategoryService extends BaseService implements ProductCategoryServiceContract
{
    /**
     * @var ProductCategoryRepository
     */
    private $repository;

    /**
     * ProductCategoryService constructor.
     *
     * @param ProductCategoryRepository $repository
     */
    public function __construct(ProductCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|mixed
     */
    public function getList()
    {
        $cacheKey = ProductCategoryCache::LIST;
        Cache::forget($cacheKey);

        if (Cache::missing($cacheKey)) {
            $productCategories = $this->repository->getAll();
            Cache::forever($cacheKey, $productCategories);
        }

        $productCategories = Cache::get($cacheKey);

        return ProductCategoryResource::collection($productCategories);
    }

    /**
     * @param int  $id
     * @param bool $status
     *
     * @return mixed
     */
    public function publish(int $id, bool $status)
    {
        $source = $this->repository->getSource();

        $this->clearCache();

        return $source::publish($id, $status);
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|mixed
     */
    public function getToMainPage()
    {
        $productCategories = $this->repository->getToMainPage();

        return ProductCategoryResource::collection($productCategories);
    }
}
