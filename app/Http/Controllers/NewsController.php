<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Domain\ServiceContracts\NewsServiceContract;
use Illuminate\Auth\Access\AuthorizationException;

/**
 * Class NewsController
 * @package App\Http\Controllers
 */
class NewsController extends BaseFrontController
{
    /**
     * @var NewsServiceContract
     */
    private $service;

    /**
     * NewsController constructor.
     * @param NewsServiceContract $service
     */
    public function __construct(NewsServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('index', $this->service->getRepository()->getSource());

        $news = $this->service->getNewsByParams();

        $breadcrumbs = [
            [
                'title' => trans('news.index'),
            ],
        ];

        return view('news.index', [
            'breadcrumbs' => $breadcrumbs,
            'news' => $news,
        ]);
    }

    /**
     * @param int $id
     * @return View
     * @throws AuthorizationException
     */
    public function show(int $id): View
    {
        $this->authorize('details', $this->service->getRepository()->getSource());

        $news = $this->service->getNewsDetails($id);

        $breadcrumbs = [
            [
                'title' => trans('news.index'),
                'url' => route('news.index'),
            ],
            [
                'title' => $news['title'],
            ],
        ];

        return view('news.show', [
            'breadcrumbs' => $breadcrumbs,
            'news' => $news,
        ]);
    }
}



