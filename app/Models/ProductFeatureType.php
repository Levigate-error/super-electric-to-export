<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ProductFeatureType
 * @package App\Models
 */
class ProductFeatureType extends BaseModel
{
    /**
     * @var array
     */
    protected $translatableFields = ['name'];

    /**
     * @return HasMany
     */
    public function values(): HasMany
    {
        return $this->hasMany(ProductFeatureValue::class, 'product_feature_type_id')->orderBy('id', 'desc');
    }

    /**
     * @return HasMany
     */
    public function typesValues(): HasMany
    {
        return $this->hasMany(ProductFeatureTypesValues::class, 'product_feature_type_id')->orderBy('id', 'desc');
    }

    /**
     * @return HasMany
     */
    public function typesDivisions(): HasMany
    {
        return $this->hasMany(ProductFeatureTypesDivisions::class, 'product_feature_type_id')->orderBy('id', 'desc');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithProducts(Builder $query): Builder
    {
        return $query
            ->join('product_feature_types_values', 'product_feature_types.id', '=', 'product_feature_types_values.product_feature_type_id')
            ->join('products', 'products.id', '=', 'product_feature_types_values.product_id');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopePublishedDivisions(Builder $query): Builder
    {
        return $query
            ->join('product_feature_types_divisions', 'product_feature_types.id', '=', 'product_feature_types_divisions.product_feature_type_id')
            ->where(['product_feature_types_divisions.published' => true]);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->withProducts()
            ->join('product_divisions', 'product_divisions.id', '=', 'products.division_id')
            ->join('product_categories', 'product_categories.id', '=', 'products.category_id')
            ->join('product_families', 'product_families.id', '=', 'products.family_id')
            ->where([
                'product_divisions.published' => true,
                'product_categories.published' => true,
                'product_families.published' => true,
            ]);
    }
}
