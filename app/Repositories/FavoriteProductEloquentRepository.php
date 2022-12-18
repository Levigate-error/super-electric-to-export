<?php

namespace App\Repositories;

use App\Domain\Repositories\FavoriteProductRepository;
use App\Models\FavoriteProduct;
use App\Traits\HasSourceGetter;

/**
 * Class FavoriteProductEloquentRepository
 * @package App\Repositories
 */
class FavoriteProductEloquentRepository implements FavoriteProductRepository
{
    use HasSourceGetter;

    /**
     * @var string
     */
    private $source = FavoriteProduct::class;
}
