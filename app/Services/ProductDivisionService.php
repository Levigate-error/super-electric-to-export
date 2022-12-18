<?php

namespace App\Services;

use App\Domain\Dictionaries\Cache\ProductDivisionCache;
use App\Http\Resources\ProductDivisionResource;
use App\Domain\ServiceContracts\ProductDivisionServiceContract;
use App\Domain\Repositories\ProductDivisionRepository;
use Illuminate\Support\Facades\Cache;

/**
 * Class ProductDivisionService
 * @package App\Services
 */
class ProductDivisionService extends BaseService implements ProductDivisionServiceContract
{
    /**
     * @var ProductDivisionRepository
     */
    private $repository;

    /**
     * ProductDivisionService constructor.
     *
     * @param ProductDivisionRepository $repository
     */
    public function __construct(ProductDivisionRepository $repository)
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
        $cacheTagKey = ProductDivisionCache::LIST;
        $cacheKey = $this->generateCacheHash($params);

        if (Cache::tags($cacheTagKey)->missing($cacheKey)) {
            $productDivisions = $this->repository->getAllByRelationIds($params);
            Cache::tags($cacheTagKey)->forever($cacheKey, $productDivisions);
        }

        $productDivisions = Cache::tags($cacheTagKey)->get($cacheKey);

        return ProductDivisionResource::collection($productDivisions);
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
