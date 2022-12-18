<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ProductFamily
 * @package App\Models
 */
class ProductFamily extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'published'];

    /**
     * @var array
     */
    protected $translatableFields = ['name'];

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'family_id')->orderBy('recommended_retail_price', 'asc');;
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithProducts(Builder $query): Builder
    {
        return $query->join('products', 'product_families.id', '=', 'products.family_id');
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
        return $query
            ->withProducts()
            ->join('product_divisions', 'product_divisions.id', '=', 'products.division_id')
            ->join('product_categories', 'product_categories.id', '=', 'products.category_id')
            ->where([
                'product_divisions.published' => true,
                'product_categories.published' => true,
                'product_families.published' => true,
            ]);;
    }
}
