<?php

namespace App\Http\Controllers;

use App\Domain\ServiceContracts\Video\VideoServiceContract;
use App\Domain\ServiceContracts\Video\VideoCategoryServiceContract;
use Illuminate\View\View;

/**
 * Class VideoController
 * @package App\Http\Controllers
 */
class VideoController extends BaseFrontController
{
    /**
     * @var VideoServiceContract
     */
    private $service;

    /**
     * @var VideoCategoryServiceContract
     */
    private $videoCategoryService;

    /**
     * VideoController constructor.
     * @param VideoServiceContract $service
     * @param VideoCategoryServiceContract $videoCategoryService
     */
    public function __construct(VideoServiceContract $service, VideoCategoryServiceContract $videoCategoryService)
    {
        $this->service = $service;
        $this->videoCategoryService = $videoCategoryService;
    }

    /**
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('index', $this->service->getRepository()->getSource());

        $videoCategories = $this->videoCategoryService->getVideoCategoriesByParams();

        $breadcrumbs = [
            [
                'title' => trans('video.index'),
            ],
        ];

        return view('video.index', [
            'breadcrumbs' => $breadcrumbs,
            'videoCategories' => $videoCategories,
        ]);
    }
}
