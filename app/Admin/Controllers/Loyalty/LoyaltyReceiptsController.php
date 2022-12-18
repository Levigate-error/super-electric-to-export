<?php

namespace App\Admin\Controllers\Loyalty;

use App\Admin\Services\Loyalty\LoyaltyReceiptsAdminService;
use Encore\Admin\Layout\Content;
use App\Admin\Controllers\BaseController;

/**
 * Class FeedbackController
 * @package App\Admin\Controllers
 */
class LoyaltyReceiptsController extends BaseController
{
    protected const PAGE_HEADER = 'Чеки';

    /**
     * @var LoyaltyReceiptsAdminService
     */
    protected $service;

    /**
     * FeedbackController constructor.
     * @param LoyaltyReceiptsAdminService $service
     */
    public function __construct(LoyaltyReceiptsAdminService $service)
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    protected function getIndexUrl(): string
    {
        return route('admin.loyalty-program.receipts.index');
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
