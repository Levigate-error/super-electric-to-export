<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ProductFeatureValue
 * @package App\Models
 */
class ProductFeatureValue extends BaseModel
{
    /**
     * @var array
     */
    protected $translatableFields = ['value'];

    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(ProductFeatureType::class, 'product_feature_type_id');
    }

    /**
     * @return HasMany
     */
    public function typesValues(): HasMany
    {
        return $this->hasMany(ProductFeatureTypesValues::class, 'product_feature_value_id')->orderBy('id', 'desc');
    }
}
