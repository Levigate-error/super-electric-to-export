<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Collections\BannerCollection;

/**
 * Class Banner
 * @package App\Models
 */
class Banner extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['title', 'url', 'for_registered', 'published'];

    /**
     * @param array $models
     * @return BannerCollection
     */
    public function newCollection(array $models = []): BannerCollection
    {
        return new BannerCollection($models);
    }

    /**
     * @return MorphMany
     */
    public function images(): morphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @param Builder $query
     * @param bool $published
     * @return Builder
     */
    public function scopePublished(Builder $query, bool $published = true): Builder
    {
        return $query->where([
            'published' => $published,
        ]);
    }

    /**
     * @param Builder $query
     * @param bool $forRegistered
     * @return Builder
     */
    public function scopeRegistered(Builder $query, bool $forRegistered = true): Builder
    {
        return $query->where([
            'for_registered' => $forRegistered
        ]);
    }
}
