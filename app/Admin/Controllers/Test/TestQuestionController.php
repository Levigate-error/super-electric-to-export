<?php

namespace App\Admin\Controllers\Test;

use App\Admin\Controllers\BaseController;
use App\Admin\Services\Test\TestQuestionService;

/**
 * Class TestQuestionController
 * @package App\Admin\Controllers\Test
 */
class TestQuestionController extends BaseController
{
    protected const PAGE_HEADER = 'Вопросы';

    /**
     * @var TestQuestionService
     */
    protected $service;

    /**
     * TestQuestionController constructor.
     * @param TestQuestionService $service
     */
    public function __construct(TestQuestionService $service)
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    protected function getIndexUrl(): string
    {
        return route('admin.test.question.index');
    }
}
