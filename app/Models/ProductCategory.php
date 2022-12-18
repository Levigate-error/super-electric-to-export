<?php

namespace App\Models;

use App\Models\Project\Project;
use App\Models\Project\ProjectSpecification;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

/**
 * Class ProductCategory
 * @package App\Models
 */
class ProductCategory extends BaseModel
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
        return $this->hasMany(Product::class, 'category_id')->orderBy('recommended_retail_price', 'asc');
    }

    /**
     * @return HasMany
     */
    public function divisions(): HasMany
    {
        return $this->hasMany(ProductDivision::class, 'category_id')->orderBy('id', 'desc');
    }

    /**
     * @return BelongsToMany
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_product_categories');
    }

    /**
     * @return BelongsToMany
     */
    public function specifications(): BelongsToMany
    {
        return $this->belongsToMany(ProjectSpecification::class, 'specification_product_categories');
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
     * @param $query
     * @return Builder
     */
    public function scopePublished($query): Builder
    {
        return $query->where(['published' => true]);
    }

    /**
     * @param $query
     * @return Builder
     */
    public function scopeToMain($query): Builder
    {
        return $query->where(['in_main' => true]);
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
