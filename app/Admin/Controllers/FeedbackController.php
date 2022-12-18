<?php

namespace App\Admin\Controllers;

use App\Admin\Services\FeedbackService;
use Encore\Admin\Layout\Content;

/**
 * Class FeedbackController
 * @package App\Admin\Controllers
 */
class FeedbackController extends BaseController
{
    protected const PAGE_HEADER = 'Обратная связь';

    /**
     * @var FeedbackService
     */
    protected $service;

    /**
     * FeedbackController constructor.
     * @param FeedbackService $service
     */
    public function __construct(FeedbackService $service)
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    protected function getIndexUrl(): string
    {
        return route('admin.feedback.index');
    }

    /**
     * @param  Content  $content
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
            ->row($this->service->getTabsContent())
            ->row($this->service->getCrudPageContent());
    }

    /**
     * @param  int  $id
     * @param  Content  $content
     * @return Content
     */
    public function edit(int $id, Content $content): Content
    {
        $content = parent::edit($id, $content);

        return $content->description(static::PAGE_DESCRIPTION_DETAILS)
            ->breadcrumb(
                ['text' => 'Список', 'url' => $this->getIndexUrl()],
                ['text' => static::PAGE_DESCRIPTION_DETAILS]
            );
    }
}
