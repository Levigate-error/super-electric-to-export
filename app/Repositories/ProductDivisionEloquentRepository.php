<?php

namespace App\Repositories;

use App\Models\ProductDivision;
use App\Domain\Repositories\ProductDivisionRepository;
use Illuminate\Support\Collection;
use App\Traits\HasSourceGetter;

/**
 * Class ProductCategoryService
 * @package App\Services
 */
class ProductDivisionEloquentRepository implements ProductDivisionRepository
{
    use HasSourceGetter;

    private $source = ProductDivision::class;

    /**
     * @param array $relations
     *
     * @return Collection
     */
    public function getAllByRelationIds(array $relations): Collection
    {
        $query = $this->getSource()::published()->select([
            'product_divisions.*',
        ]);

        if (isset($relations['category'])) {
            $query->where([
                'product_divisions.category_id' => $relations['category'],
            ]);
        }

        if (isset($relations['family'])) {
            $query->withProducts();

            $query->where([
                'products.family_id' => $relations['family'],
            ]);
        }

        return $query->groupBy('product_divisions.id')->get();
    }
}
