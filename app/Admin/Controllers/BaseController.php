<?php

namespace App\Admin\Controllers;

use App\Admin\Services\BaseService;
use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\HasResourceActions;

/**
 * Class BaseController
 * @package App\Admin\Controllers
 */
abstract class BaseController extends Controller
{
    use HasResourceActions;

    protected const PAGE_HEADER = ' ';
    protected const PAGE_DESCRIPTION_LIST = 'Список';
    protected const PAGE_DESCRIPTION_CREATE = 'Добавление';
    protected const PAGE_DESCRIPTION_EDIT = 'Редактирование';
    protected const PAGE_DESCRIPTION_DETAILS = 'Подробности';

    /**
     * @var BaseService
     */
    protected $service;

    /**
     * @return string
     */
    protected function getIndexUrl(): string
    {
        return '';
    }

    /**
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content): Content
    {
        return $content
            ->header(static::PAGE_HEADER)
            ->description(static::PAGE_DESCRIPTION_LIST)
            ->breadcrumb([
                'text' => static::PAGE_DESCRIPTION_LIST
            ])
            ->body($this->service->getCrudPageContent());
    }

    /**
     * @param Content $content
     * @return Content
     */
    public function create(Content $content): Content
    {
        $content->header(static::PAGE_HEADER)
            ->description(static::PAGE_DESCRIPTION_CREATE)
            ->body($this->form());

        if (empty($this->getIndexUrl()) === false) {
            $content->breadcrumb(
                ['text' => 'Список', 'url' => $this->getIndexUrl()],
                ['text' => static::PAGE_DESCRIPTION_CREATE]
            );
        }

        return $content;
    }

    /**
     * @param int $id
     * @param Content $content
     * @return Content
     */
    public function edit(int $id, Content $content): Content
    {
        $content->header(static::PAGE_HEADER)
            ->description(static::PAGE_DESCRIPTION_EDIT)
            ->body($this->form()->edit($id));

        if (empty($this->getIndexUrl()) === false) {
            $content->breadcrumb(
                ['text' => 'Список', 'url' => $this->getIndexUrl()],
                ['text' => static::PAGE_DESCRIPTION_EDIT]
            );
        }

        return $content;
    }

    /**
     * @param int $id
     * @param Content $content
     * @return Content
     */
    public function show(int $id, Content $content): Content
    {
        $content->header(static::PAGE_HEADER)
            ->description(static::PAGE_DESCRIPTION_DETAILS)
            ->body($this->service->getDetailPageContent($id));

        if (empty($this->getIndexUrl()) === false) {
            $content->breadcrumb(
                ['text' => 'Список', 'url' => $this->getIndexUrl()],
                ['text' => static::PAGE_DESCRIPTION_DETAILS]
            );
        }

        return $content;
    }

    /**
     * @return mixed
     */
    protected function form()
    {
        return $this->service->getFormContent();
    }
}
