<?php

namespace App\Admin\Controllers;

use App\Admin\Services\FaqService;

/**
 * Class FaqController
 * @package App\Admin\Controllers
 */
class FaqController extends BaseController
{
    protected const PAGE_HEADER = 'FAQ';

    /**
     * @var FaqService
     */
    protected $service;

    /**
     * VideoController constructor.
     * @param FaqService $service
     */
    public function __construct(FaqService $service)
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    protected function getIndexUrl(): string
    {
        return route('admin.faq.index');
    }
}
