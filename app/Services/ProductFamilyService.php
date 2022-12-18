<?php

namespace App\Services;

use App\Http\Resources\ProductFamilyResource;
use App\Domain\ServiceContracts\ProductFamilyServiceContract;
use App\Domain\Repositories\ProductFamilyRepository;
use Illuminate\Support\Facades\Cache;
use App\Domain\Dictionaries\Cache\ProductFamilyCache;

/**
 * Class ProductCategoryService
 * @package App\Services
 */
class ProductFamilyService extends BaseService implements ProductFamilyServiceContract
{
    /**
     * @var ProductFamilyRepository
     */
    private $repository;

    /**
     * ProductFamilyService constructor.
     *
     * @param ProductFamilyRepository $repository
     */
    public function __construct(ProductFamilyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $params
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|mixed
     */
    public function getListByParams(array $params)
    {
        $cacheTagKey = ProductFamilyCache::LIST;
        $cacheKey = $this->generateCacheHash($params);

        if (Cache::tags($cacheTagKey)->missing($cacheKey)) {
            $productFamilies = $this->repository->getAllByRelationIds($params);
            Cache::tags($cacheTagKey)->forever($cacheKey, $productFamilies);
        }

        $productFamilies = Cache::tags($cacheTagKey)->get($cacheKey);

        foreach ($productFamilies as $family) {
            translate($family);
        }

        return ProductFamilyResource::collection($productFamilies);
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
}
