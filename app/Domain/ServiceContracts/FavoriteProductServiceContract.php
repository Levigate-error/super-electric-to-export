<?php

namespace App\Domain\ServiceContracts;

use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Interface FavoriteProductServiceContract
 * @package App\Domain\ServiceContracts
 */
interface FavoriteProductServiceContract
{
    /**
     * @param array           $products
     * @param Authenticatable $user
     *
     * @return mixed
     */
    public function addProductsToFavorite(array $products, Authenticatable $user);

    /**
     * @param array           $products
     * @param Authenticatable $user
     *
     * @return mixed
     */
    public function removeProductsFromFavorite(array $products, Authenticatable $user);
}
