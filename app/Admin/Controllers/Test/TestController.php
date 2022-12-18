<?php

namespace App\Admin\Controllers\Test;

use App\Admin\Controllers\BaseController;
use App\Admin\Services\Test\TestService;

/**
 * Class TestController
 * @package App\Admin\Controllers\Test
 */
class TestController extends BaseController
{
    protected const PAGE_HEADER = 'Тесты';

    /**
     * @var TestService
     */
    protected $service;

    /**
     * TestController constructor.
     * @param TestService $service
     */
    public function __construct(TestService $service)
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    protected function getIndexUrl(): string
    {
        return route('admin.test.main.index');
    }
}
