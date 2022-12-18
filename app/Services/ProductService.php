<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductDetailResource;
use App\Domain\ServiceContracts\ProductServiceContract;
use App\Domain\Repositories\ProductRepository;
use App\Models\BaseModel;
use Illuminate\Support\Facades\Cache;
use App\Domain\Dictionaries\Cache\ProductCache;

/**
 * Class ProductFeatureService
 * @package App\Services
 */
class ProductService extends BaseService implements ProductServiceContract
{
    /**
     * @var ProductRepository
     */
    private $repository;

    /**
     * ProductService constructor.
     *
     * @param ProductRepository $repository
     */
    public function __construct(ProductRepository $repository)
    {
        $this->setRepository($repository);
    }

    /**
     * @return ProductRepository
     */
    public function getRepository(): ProductRepository
    {
        return $this->repository;
    }

    /**
     * @param ProductRepository $repository
     */
    public function setRepository(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $params
     * @return array
     */
    public function getProductsByParams(array $params = []): array
    {
        $cacheTagKey = ProductCache::LIST;
        $cacheKey = $this->generateCacheHash($params);

        if (Cache::tags($cacheTagKey)->missing($cacheKey)) {
            $products = $this->repository->getProductsByParams($params);

            foreach ($products as $product) {
                $product->attributes = $product->features;
            }

            Cache::tags($cacheTagKey)->forever($cacheKey, $products);
        }

        $products = Cache::tags($cacheTagKey)->get($cacheKey);

        foreach ($products as $product) {
            $this->translateProductWithParams($product);
        }

        return [
            'total' => $products->total(),
            'lastPage' => $products->lastPage(),
            'currentPage' => $products->currentPage(),
            'products' => ProductResource::collection(collect($products->items())),
        ];
    }

    /**
     * @param array $conditions
     * @return ProductDetailResource|null
     */
    public function getProductByParam(array $conditions): ?ProductDetailResource
    {
        $product = $this->repository->getProductByParam($conditions);

        if ($product === null) {
            return null;
        }

        return $this->getProductDetails($product->id);
    }

    /**
     * @param int $productId
     * @return ProductDetailResource
     */
    public function getProductDetails(int $productId): ProductDetailResource
    {
        $cacheTagKey = ProductCache::DETAILS;
        $cacheKey = $this->generateCacheHash($productId);

        if (Cache::tags($cacheTagKey)->missing($cacheKey)) {
            $product = $this->repository->getProductDetails($productId);
            $product->attributes = $product->features;

            Cache::tags($cacheTagKey)->forever($cacheKey, $product);
        }

        $product = Cache::tags($cacheTagKey)->get($cacheKey);

        $this->translateProductWithParams($product);

        return ProductDetailResource::make($product);
    }

    /**
     * @param BaseModel $product
     * @return BaseModel
     */
    public function translateProductWithParams(BaseModel $product): BaseModel
    {
        if (isset($product->attributes)) {
            $translatedAttributes = [];
            foreach ($product->attributes as $attribute) {

                if (!isset($attribute['title']) || !isset($attribute['value'])) {
                    continue;
                }

                $translatedAttributes[] = [
                    'title' => translate_field($attribute['title']),
                    'value' => translate_field($attribute['value']),
                ];
            }
            $product->attributes = $translatedAttributes;
        }

        if (isset($product->images)) {
            translate_collection($product->images);
        }

        if (isset($product->instructions)) {
            translate_collection($product->instructions);
        }

        if (isset($product->videos)) {
            translate_collection($product->videos);
        }

        if (isset($product->popular_products)) {
            translate_collection($product->popular_products);
        }

        if (isset($product->recommend_products)) {
            translate_collection($product->recommend_products);
        }

        translate($product->family);

        return $product;
    }

    /**
     * @return array
     */
    public function getRecommendedProducts(): array
    {
        $cacheTagKey = ProductCache::RECOMMENDED;
        $cacheKey = $this->generateCacheHash('getRecommendedProducts');

        if (Cache::tags($cacheTagKey)->missing($cacheKey) === true) {
            $products = $this->repository->getRecommendedProducts();

            foreach ($products as $product) {
                $product->attributes = $product->features;
            }

            Cache::tags($cacheTagKey)->forever($cacheKey, $products);
        }

        $products = Cache::tags($cacheTagKey)->get($cacheKey);

        foreach ($products as $product) {
            $this->translateProductWithParams($product);
        }

        return ProductResource::collection($products)->resolve();
    }

    /**
     * @param int $productId
     * @return array
     */
    public function getBuyWithItProducts(int $productId): array
    {
        $products = $this->repository->getBuyWithItProducts($productId);

        foreach ($products as $product) {
            $product->attributes = $product->features;
        }

        foreach ($products as $product) {
            $this->translateProductWithParams($product);
        }

        return ProductResource::collection($products)->resolve();
    }
}
