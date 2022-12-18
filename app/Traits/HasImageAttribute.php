<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

/**
 * Trait HasImageAttribute
 * @package App\Traits
 */
trait HasImageAttribute
{
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
