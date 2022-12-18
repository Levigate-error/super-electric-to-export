<?php

namespace App\Admin\Controllers\Video;

use App\Admin\Controllers\BaseController;
use App\Admin\Services\Video\VideoService;

/**
 * Class VideoController
 * @package App\Admin\Controllers\Video
 */
class VideoController extends BaseController
{
    protected const PAGE_HEADER = 'Видео';

    /**
     * @var VideoService
     */
    protected $service;

    /**
     * VideoController constructor.
     * @param VideoService $service
     */
    public function __construct(VideoService $service)
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    protected function getIndexUrl(): string
    {
        return route('admin.video.videos.index');
    }
}
