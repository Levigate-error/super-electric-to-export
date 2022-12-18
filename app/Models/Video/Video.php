<?php

namespace App\Models\Video;

use App\Models\BaseModel;
use App\Collections\Video\VideoCollection;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Video
 * @package App\Models\Video
 */
class Video extends BaseModel
{
    use Translatable;

    /**
     * @var array
     */
    protected $translatableFields = ['title'];

    /**
     * @var array
     */
    protected $fillable = ['title', 'video', 'published', 'video_category_id'];

    /**
     * @param array $models
     * @return VideoCollection
     */
    public function newCollection(array $models = []): VideoCollection
    {
        return new VideoCollection($models);
    }

    /**
     * @return BelongsTo
     */
    public function videoCategory(): BelongsTo
    {
        return $this->belongsTo(VideoCategory::class);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where([
                'published' => true,
            ])->whereHas('videoCategory', static function (Builder $videoCategoryBuilder) {
                return $videoCategoryBuilder->published();
            });
    }
}
