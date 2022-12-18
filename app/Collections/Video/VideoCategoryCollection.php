<?php

namespace App\Collections\Video;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Video\VideoCategory;

/**
 * Class VideoCategoryCollection
 * @package App\Collections\Video
 */
class VideoCategoryCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [VideoCategory::class];
}
