<?php

namespace App\Collections\Video;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Video\Video;

/**
 * Class VideoCollection
 * @package App\Collections\Video
 */
class VideoCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [Video::class];
}
