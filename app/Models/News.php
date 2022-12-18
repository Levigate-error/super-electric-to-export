<?php

namespace App\Models;

use App\Collections\NewsCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

/**
 * Class News
 * @package App\Models
 */
class News extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['title', 'description', 'short_description', 'published', 'image'];

    /**
     * @param array $models
     * @return NewsCollection
     */
    public function newCollection(array $models = []): NewsCollection
    {
        return new NewsCollection($models);
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
