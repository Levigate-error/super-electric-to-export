<?php

namespace App\Observers;

use App\Models\Video\Video;
use App\Utils\YouTubeLinkConverter;

/**
 * Class VideoObserver
 * @package App\Observers
 */
class VideoObserver
{
    /**
     * @param Video $video
     */
    public function saving(Video $video): void
    {
        $video->video = YouTubeLinkConverter::convert($video->video);
    }
}
