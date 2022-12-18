<?php

namespace App\Models\Video;

use App\Models\BaseModel;
use App\Collections\Video\VideoCategoryCollection;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class VideoCategory
 * @package App\Models\Video
 */
class VideoCategory extends BaseModel
{
    use Translatable;

    /**
     * @var array
     */
    protected $translatableFields = ['title'];

    /**
     * @var array
     */
    protected $fillable = ['title', 'published'];

    /**
     * @param array $models
     * @return VideoCategoryCollection
     */
    public function newCollection(array $models = []): VideoCategoryCollection
    {
        return new VideoCategoryCollection($models);
    }

    /**
     * @return HasMany
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where([
            'published' => true,
        ]);
    }
}
