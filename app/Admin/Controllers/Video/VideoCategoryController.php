<?php

namespace App\Admin\Controllers\Video;

use App\Admin\Controllers\BaseController;
use App\Admin\Services\Video\VideoCategoryService;

/**
 * Class VideoCategoryController
 * @package App\Admin\Controllers\Video
 */
class VideoCategoryController extends BaseController
{
    protected const PAGE_HEADER = 'Категории видео';

    /**
     * @var VideoCategoryService
     */
    protected $service;

    /**
     * VideoCategoryController constructor.
     * @param VideoCategoryService $service
     */
    public function __construct(VideoCategoryService $service)
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    protected function getIndexUrl(): string
    {
        return route('admin.video.categories.index');
    }
}
