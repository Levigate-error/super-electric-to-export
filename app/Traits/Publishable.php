<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait Publishable
 * @package App\Traits
 */
trait Publishable
{
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
}
