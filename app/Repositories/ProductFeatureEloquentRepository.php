<?php

namespace App\Repositories;

use App\Models\ProductFeatureType;
use App\Models\ProductFeatureValue;
use App\Domain\Repositories\ProductFeatureRepository;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ProductFeatureEloquentRepository
 * @package App\Repositories
 */
class ProductFeatureEloquentRepository implements ProductFeatureRepository
{
    /**
     * @param array $params
     *
     * @return Collection
     */
    public function getFiltersByParams(array $params = []): Collection
    {
        $query = ProductFeatureType::query()
            ->published()
            ->select(['product_feature_types.*'])
            ->groupBy('product_feature_types.id');

        if (isset($params['family'])) {
            $query->where(['products.family_id' => $params['family']]);
        }

        if (isset($params['category'])) {
            $query->where(['product_divisions.category_id' => $params['category']]);
        }

        if (isset($params['division'])) {
            $query->publishedDivisions();
            $query->where(['product_feature_types_divisions.product_division_id' => $params['division']]);
        }

        return $query->with('values')->get();
    }

    /**
     * @param ProductFeatureValue $model
     * @param array               $params
     *
     * @return int
     */
    public function getFeatureValueProductCountByParams(ProductFeatureValue $model, array $params): int
    {
        $result = $productCount = $model->typesValues()->whereHas('product', function (Builder $builder) use ($params) {
            if (isset($params['category'])) {
                $builder->where(['products.category_id' => $params['category'],]);
            }

            if (isset($params['family'])) {
                $builder->where(['products.family_id' => $params['family'],]);
            }

            if (isset($params['division'])) {
                $builder->where(['products.division_id' => $params['division'],]);
            }
        })->count();

        return $result;
    }

}
