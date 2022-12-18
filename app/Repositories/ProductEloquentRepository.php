<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\BaseModel;
use App\Domain\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * Class ProductFeatureEloquentRepository
 * @package App\Repositories
 */
class ProductEloquentRepository extends BaseRepository implements ProductRepository
{
    protected $source = Product::class;

    /**
     * @param  array  $params
     * @return LengthAwarePaginator
     */
    public function getProductsByParams(array $params = []): LengthAwarePaginator
    {
        $query = $this->getQueryBuilder()
            ->select('products.*')
            ->published();

        if (isset($params['favorite_user_id'])) {
            $query->whereHas('favorites', static function (Builder $builder) use ($params) {
                return $builder->where(['favorite_products.user_id' => $params['favorite_user_id']]);
            });
        }

        if (isset($params['category'])) {
            $query->where(['products.category_id' => $params['category']]);
        }

        if (isset($params['family'])) {
            $query->where(['products.family_id' => $params['family']]);
        }

        if (isset($params['division'])) {
            $query->where(['products.division_id' => $params['division']]);
        }

        if (isset($params['is_loyalty'])) {
            $query->where(['products.is_loyalty' => $params['is_loyalty']]);
        }

        if (isset($params['filter_values'])) {
            foreach ($params['filter_values'] as $filter_value) {
                $query->whereHas('featureTypesValues', static function (Builder $builder) use ($filter_value) {
                    $builder->where([
                        'product_feature_type_id' => $filter_value['type_id'],
                    ])->whereIn('product_feature_value_id', $filter_value['values']);

                    return $builder;
                });
            }
        }

        if (isset($params['price_from'])) {
            $query->where('products.recommended_retail_price', '>=', $params['price_from']);
        }

        if (isset($params['price_to'])) {
            $query->where('products.recommended_retail_price', '<=', $params['price_to']);
        }

        if (isset($params['search'])) {
            $locale = get_current_local();

            $query->where(static function (Builder $query) use ($params, $locale) {
                $query->orWhere('products.name->'.$locale, 'ILIKE', '%'.$params['search'].'%');
                $query->orWhere('products.vendor_code', '=', $params['search']);

                $query->orWhereHas('featureTypesValues', static function (Builder $builder) use ($params, $locale) {
                    $builder->whereHas('value', static function (Builder $valueBuilder) use ($params, $locale) {
                        $valueBuilder->where('product_feature_values.value->'.$locale, 'ILIKE',
                            '%'.$params['search'].'%');

                        return $valueBuilder;
                    });
                });
            });
        }

        if (isset($params['sort_type']) === false) {
            $params['sort_type'] = 'desc';
        }

        if (isset($params['sort_column']) === false) {
            $params['sort_column'] = 'rank';
        }

        $query->orderBy("products.{$params['sort_column']}", $params['sort_type']);

        /**
         * Эту штука нужна на случай, если номер страницы передается не в реквесте. У меня так получилось при
         * генерировании фейковых проектов.
         */
        if (isset($params['page'])) {
            return $query->paginate($params['limit'], ['*'], 'page', $params['page']);
        }

        return $query->paginate($params['limit']);
    }

    /**
     * @param  int  $productId
     * @return BaseModel
     */
    public function getProductDetails(int $productId): BaseModel
    {
        $locale = get_current_local();

        $product = $this->getQueryBuilder()->findOrFail($productId);
        $product->load(['category', 'division', 'family']);
        $product->images = $product->files()->where(['type' => 'Image'])->get();
        $product->instructions = $product->files()->where("description->$locale", 'like',
            '%'.trans('settings.instructions').'%')->get();
        $product->videos = $product->files()->where("description->$locale", 'like',
            '%'.trans('settings.videos').'%')->get();

        $product->popular_products = $this->getSource()::query()->get()->random(8);
        $product->recommend_products = $this->getSource()::query()->get()->random(8);

        return $product;
    }

    /**
     * @param  array  $where
     * @return BaseModel|null
     */
    public function getProductByParam(array $where): ?BaseModel
    {
        return $this->getQueryBuilder()
            ->where($where)
            ->first();
    }

    /**
     * @return Collection
     */
    public function getRecommendedProducts(): Collection
    {
        return $this->getQueryBuilder()
            ->published()
            ->isRecommended()
            ->limit(config('products.recommended_limit'))
            ->orderBy('rank', 'asc')
            ->get();
    }

    /**
     * @param  int  $productId
     * @return Collection
     */
    public function getBuyWithItProducts(int $productId): Collection
    {
        return $this->getQueryBuilder()
            ->select('products.*')
            ->published()
            ->leftJoin('project_products', 'project_products.product_id', '=', 'products.id')
            ->whereIn('project_products.project_id', static function (QueryBuilder $query) use ($productId) {
                return $query
                    ->select('project_products.project_id')
                    ->from('project_products')
                    ->where([
                        'project_products.product_id' => $productId,
                    ]);
            })
            ->where('products.id', '!=', $productId)
            ->limit(config('products.buy_with_it_limit'))
            ->orderBy('rank', 'asc')
            ->groupBy('products.id')
            ->get();
    }
}
