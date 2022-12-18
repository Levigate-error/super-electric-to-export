<?php

namespace App\Models;

use App\Collections\FaqCollection;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Faq
 * @package App\Models
 */
class Faq extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['question', 'answer', 'published'];

    /**
     * @param array $models
     * @return FaqCollection
     */
    public function newCollection(array $models = []): FaqCollection
    {
        return new FaqCollection($models);
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
