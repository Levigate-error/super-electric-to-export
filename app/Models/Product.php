<?php

namespace App\Models;

use App\Models\Project\Project;
use App\Traits\Translatable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class Product
 * @package App\Models
 */
class Product extends BaseModel
{
    use Translatable;

    const PRODUCT_DATA = ['vendor_code', 'name', 'recommended_retail_price', 'min_amount', 'unit'];

    /**
     * @var array
     */
    protected $translatableFields = ['name', 'unit', 'description'];

    /**
     * @var array
     */
    protected $fillable = [
        'rank', 'vendor_code', 'name', 'recommended_retail_price', 'min_amount', 'unit',
        'category_id', 'division_id', 'family_id', 'description', 'is_recommended', 'rank',
        'is_loyalty',
    ];

    protected $casts = [
        'is_recommended' => 'boolean',
        'rank' => 'integer',
        'is_loyalty' => 'boolean',
    ];

    /**
     * @return HasMany
     */
    public function featureTypesValues(): HasMany
    {
        return $this->hasMany(ProductFeatureTypesValues::class, 'product_id');
    }

    /**
     * @return BelongsTo
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(ProductDivision::class, 'division_id');
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * @return BelongsTo
     */
    public function family(): BelongsTo
    {
        return $this->belongsTo(ProductFamily::class, 'family_id');
    }

    /**
     * @return HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(ProductFiles::class, 'product_id');
    }

    /**
     * @return HasMany
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(FavoriteProduct::class, 'product_id');
    }

    /**
     * @return belongsToMany
     */
    public function projects(): belongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_products');
    }

    /**
     * @return BelongsToMany
     */
    public function analogues(): BelongsToMany
    {
        return $this->belongsToMany(Analogue::class);
    }

    /**
     * @return string
     */
    public function getMainImageAttribute(): string
    {
        $firstImage = $this->files()->where(['type' => 'Image'])->first();

        return !empty($firstImage) ? $firstImage->file_link : '';
    }

    /**
     * @return bool
     * @throws BindingResolutionException
     */
    public function getIsFavoritesAttribute(): bool
    {
        $user = app()->make(Authenticatable::class);
        if (!$user) {
            return false;
        }

        $favorite = $this->favorites()->where(['user_id' => $user->getAuthIdentifier()])->first();

        return !empty($favorite);
    }

    /**
     * @return array
     */
    public function getFeaturesAttribute(): array
    {
        $currentFeatures = [];

        foreach ($this->featureTypesValues()->byPublishDivisionType($this->division)->get() as $featureTypeValue) {
            $featureType = $featureTypeValue->type;
            $featureValue = $featureTypeValue->value;

            $currentFeatures[] = [
                'title' => $featureType->name,
                'value' => $featureValue->value
            ];
        }

        return $currentFeatures;
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->whereHas('division', static function (Builder $builder) {
            return $builder->published();
        })->whereHas('category', static function (Builder $builder) {
            return $builder->published();
        })->whereHas('family', static function (Builder $builder) {
            return $builder->published();
        });
    }

    /**
     * @param int $usedProductAmount
     * @return bool
     */
    public function setNotUsedAmount(int $usedProductAmount): bool
    {
        if (empty($this->pivot)) {
            return false;
        }

        $this->pivot->not_used_amount = $this->pivot->amount - $usedProductAmount;

        return $this->pivot->save();
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeActiveProducts(Builder $query): Builder
    {
        return $query->whereHas('projects', static function ($query) {
            $query->where(['project_products.active' => true]);
        });
    }

    /**
     * Инкремент ранга товара
     *
     * @return bool
     */
    public function incrementRank(): bool
    {
        $this->rank++;

        return $this->saveQuietly();
    }

    /**
     * @param Builder $query
     * @param bool $isRecommended
     * @return Builder
     */
    public function scopeIsRecommended(Builder $query, bool $isRecommended = true): Builder
    {
        return $query->where([
            'is_recommended' => $isRecommended,
        ]);
    }
}
