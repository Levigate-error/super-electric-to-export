<?php

namespace App\Repositories;

use App\Models\ProductFamily;
use App\Domain\Repositories\ProductFamilyRepository;
use Illuminate\Support\Collection;
use App\Traits\HasSourceGetter;

/**
 * Class ProductCategoryService
 * @package App\Services
 */
class ProductFamilyEloquentRepository implements ProductFamilyRepository
{
    use HasSourceGetter;

    private $source = ProductFamily::class;

    /**
     * @param array $relations
     *
     * @return Collection
     */
    public function getAllByRelationIds(array $relations): Collection
    {
        $query = $this->getSource()::published()->select([
            'product_families.*',
        ]);

        if (isset($relations['category'])) {
            $query->where([
                'products.category_id' => $relations['category'],
            ]);
        }

        if (isset($relations['division'])) {
            $query->where([
                'products.division_id' => $relations['division'],
            ]);
        }

        return $query->groupBy('product_families.id')->get();
    }
}
