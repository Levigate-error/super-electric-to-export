<?php

namespace App\Admin\Controllers;

use App\Admin\Services\NewsService;

/**
 * Class NewsController
 * @package App\Admin\Controllers
 */
class NewsController extends BaseController
{
    protected const PAGE_HEADER = 'Новости';

    /**
     * @var NewsService
     */
    protected $service;

    /**
     * NewsController constructor.
     * @param NewsService $service
     */
    public function __construct(NewsService $service)
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    protected function getIndexUrl(): string
    {
        return route('admin.news.index');
    }
}
