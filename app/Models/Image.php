<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

/**
 * Class Image
 * @package App\Models
 */
class Image extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['path', 'size', 'imageable_id', 'imageable_type'];

    /**
     * @return MorphTo
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getImagePathAttribute(): string
    {
        if ($this->path === null) {
            return '';
        }

        return Storage::disk('public')->url($this->path);
    }
}
