<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ProductFeatureTypesDivisions
 * @package App\Models
 */
class ProductFeatureTypesDivisions extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['published'];

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
    public function division(): BelongsTo
    {
        return $this->belongsTo(ProductDivision::class, 'product_division_id');
    }

    /**
     * @param int $id
     * @param bool $status
     * @return bool
     */
    public static function publish(int $id, bool $status): bool
    {
        return self::query()->find($id)
            ->fill([
                'published' => $status,
            ])->trySaveModel();
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where(['published' => true]);
    }
}
