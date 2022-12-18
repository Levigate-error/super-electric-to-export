<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ProductFeatureTypesValues
 * @package App\Models
 */
class ProductFeatureTypesValues extends BaseModel
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(ProductFeatureType::class, 'product_feature_type_id');
    }

    /**
     * @return BelongsTo
     */
    public function value(): BelongsTo
    {
        return $this->belongsTo(ProductFeatureValue::class, 'product_feature_value_id');
    }

    /**
     * @param Builder $query
     * @param ProductDivision $division
     * @return Builder
     */
    public function scopeByPublishDivisionType(Builder $query, ProductDivision $division): Builder
    {
        return $query
            ->join('product_feature_types_divisions', function ($join) use ($division) {
                $join->on('product_feature_types_values.product_feature_type_id', '=', 'product_feature_types_divisions.product_feature_type_id')
                    ->where([
                        'product_feature_types_divisions.published' => true,
                        'product_feature_types_divisions.product_division_id' => $division->id,
                    ]);
            });
    }
}
