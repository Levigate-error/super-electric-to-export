<?php

namespace App\Admin\Controllers\Test;

use App\Admin\Controllers\BaseController;
use App\Admin\Services\Test\TestResultService;

/**
 * Class TestResultController
 * @package App\Admin\Controllers\Test
 */
class TestResultController extends BaseController
{
    protected const PAGE_HEADER = 'Результаты';

    /**
     * @var TestResultService
     */
    protected $service;

    /**
     * TestResultController constructor.
     * @param TestResultService $service
     */
    public function __construct(TestResultService $service)
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    protected function getIndexUrl(): string
    {
        return route('admin.test.result.index');
    }
}
