<?php

namespace App\Admin\Controllers;

use App\Admin\Services\BannerService;
use Encore\Admin\Layout\Content;

/**
 * Class BannerController
 * @package App\Admin\Controllers
 */
class BannerController extends BaseController
{
    protected const PAGE_HEADER = 'Баннеры';

    /**
     * @var BannerService
     */
    protected $service;

    /**
     * BannerController constructor.
     * @param BannerService $service
     */
    public function __construct(BannerService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Content $content
     * @return Content
     */
    public function create(Content $content): Content
    {
        $content = parent::create($content);

        return $content->breadcrumb(
            ['text' => 'Список', 'url' => route('admin.banners.list')],
            ['text' => static::PAGE_DESCRIPTION_CREATE]
        );
    }

    /**
     * @param int $id
     * @param Content $content
     * @return Content
     */
    public function edit(int $id, Content $content): Content
    {
        $content = parent::edit($id, $content);

        return $content->breadcrumb(
            ['text' => 'Список', 'url' => route('admin.banners.list')],
            ['text' => static::PAGE_DESCRIPTION_EDIT]
        );
    }

    /**
     * @param int $id
     * @param Content $content
     * @return Content
     */
    public function show(int $id, Content $content): Content
    {
        $content = parent::show($id, $content);

        return $content->breadcrumb(
                ['text' => 'Список', 'url' => route('admin.banners.list')],
                ['text' => static::PAGE_DESCRIPTION_DETAILS]
            );
    }
}
