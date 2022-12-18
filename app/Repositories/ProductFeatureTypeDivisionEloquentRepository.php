<?php

namespace App\Repositories;

use App\Models\ProductFeatureTypesDivisions;
use App\Domain\Repositories\ProductFeatureTypeDivisionRepository;
use App\Traits\HasSourceGetter;

/**
 * Class ProductFeatureTypeDivisionEloquentRepository
 * @package App\Repositories
 */
class ProductFeatureTypeDivisionEloquentRepository implements ProductFeatureTypeDivisionRepository
{
    use HasSourceGetter;

    private $source = ProductFeatureTypesDivisions::class;
}
