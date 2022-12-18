<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

/**
 * Class ProductDivision
 * @package App\Models
 */
class ProductDivision extends BaseModel
{
    use Translatable;

    /**
     * @var array
     */
    protected $fillable = ['name', 'published', 'image'];

    /**
     * @var array
     */
    protected $translatableFields = ['name'];

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'division_id')->orderBy('recommended_retail_price', 'asc');
    }

    /**
     * @return HasOne
     */
    public function category(): HasOne
    {
        return $this->hasOne(ProductCategory::class, 'id', 'category_id');
    }

    /**
     * @return HasMany
     */
    public function typesDivisions(): HasMany
    {
        return $this->hasMany(ProductFeatureTypesDivisions::class, 'product_division_id')->orderBy('id', 'desc');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithProducts(Builder $query): Builder
    {
        return $query->join('products', 'product_divisions.id', '=', 'products.division_id');
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
            ->join('product_categories', 'product_categories.id', '=', 'product_divisions.category_id')
            ->where([
                'product_divisions.published' => true,
                'product_categories.published' => true,
            ]);
    }

    /**
     * @return string
     */
    public function getImagePathAttribute(): string
    {
        if ($this->image === null) {
            return '';
        }

        return Storage::disk('public')->url($this->image);
    }
}
