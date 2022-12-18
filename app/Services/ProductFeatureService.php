<?php

namespace App\Services;

use App\Http\Resources\ProductFilterResource;
use App\Domain\ServiceContracts\ProductFeatureServiceContract;
use App\Domain\Repositories\ProductFeatureRepository;
use Illuminate\Support\Facades\Cache;
use App\Domain\Dictionaries\Cache\ProductFeatureCache;

/**
 * Class ProductFeatureService
 * @package App\Services
 */
class ProductFeatureService extends BaseService implements ProductFeatureServiceContract
{
    /**
     * @var ProductFeatureRepository
     */
    private $repository;

    /**
     * ProductFeatureService constructor.
     *
     * @param ProductFeatureRepository $repository
     */
    public function __construct(ProductFeatureRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $params
     *
     * @return mixed
     */
    public function getFiltersByParams(array $params = [])
    {
        $cacheTagKey = ProductFeatureCache::LIST;
        $cacheKey = $this->generateCacheHash($params);

        if (Cache::tags($cacheTagKey)->missing($cacheKey)) {
            $productFilters = $this->repository->getFiltersByParams($params);

            $productFilters->map(function($filterType) use ($params) {
                if (method_exists($filterType, 'values')) {
                    $filterType->values->map(function($value) use ($params) {
                        $value->product_count = $this->repository->getFeatureValueProductCountByParams($value, $params);
                    });
                }
            });

            Cache::tags($cacheTagKey)->forever($cacheKey, $productFilters);
        }

        $productFilters = Cache::tags($cacheTagKey)->get($cacheKey);

        $productFilters->map(function($filterType) use ($params) {
            return translate_with_relations($filterType);
        });

        return ProductFilterResource::collection($productFilters);
    }
}
