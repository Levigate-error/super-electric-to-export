<?php

namespace App\Services;

use App\Domain\ServiceContracts\FavoriteProductServiceContract;
use App\Domain\Dictionaries\Cache\ProductCache;
use App\Domain\Repositories\FavoriteProductRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Cache;


/**
 * Class ProductFeatureService
 * @package App\Services
 */
class FavoriteProductService extends BaseService implements FavoriteProductServiceContract
{
    /**
     * @var FavoriteProductRepository
     */
    private $repository;

    /**
     * FavoriteProductService constructor.
     *
     * @param FavoriteProductRepository $repository
     */
    public function __construct(FavoriteProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array           $products
     * @param Authenticatable $user
     *
     * @return array|mixed
     */
    public function addProductsToFavorite(array $products, Authenticatable $user)
    {
        $userId = $user->getAuthIdentifier();
        $source = $this->repository->getSource();

        foreach ($products as $productId) {
            $source::addProductToFavorite($productId, $userId);
        }

        Cache::tags(ProductCache::LIST)->flush();

        return [];
    }

    /**
     * @param array           $products
     * @param Authenticatable $user
     *
     * @return array|mixed
     */
    public function removeProductsFromFavorite(array $products, Authenticatable $user)
    {
        $userId = $user->getAuthIdentifier();
        $source = $this->repository->getSource();

        foreach ($products as $productId) {
            $source::removeProductFromFavorite($productId, $userId);
        }

        Cache::tags(ProductCache::LIST)->flush();

        return [];
    }
}
