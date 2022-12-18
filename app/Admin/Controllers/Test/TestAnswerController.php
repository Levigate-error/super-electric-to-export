<?php

namespace App\Admin\Controllers\Test;

use App\Admin\Controllers\BaseController;
use App\Admin\Services\Test\TestAnswerService;

/**
 * Class TestAnswerController
 * @package App\Admin\Controllers\Test
 */
class TestAnswerController extends BaseController
{
    protected const PAGE_HEADER = 'Ответы';

    /**
     * @var TestAnswerService
     */
    protected $service;

    /**
     * TestAnswerController constructor.
     * @param TestAnswerService $service
     */
    public function __construct(TestAnswerService $service)
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    protected function getIndexUrl(): string
    {
        return route('admin.test.answer.index');
    }
}
