<?php

namespace App\Admin\Controllers;

use App\Admin\Services\SettingService;

/**
 * Class SettingController
 * @package App\Admin\Controllers
 */
class SettingController extends BaseController
{
    protected const PAGE_HEADER = 'Настройки';

    /**
     * @var SettingService
     */
    protected $service;

    /**
     * SettingController constructor.
     * @param SettingService $service
     */
    public function __construct(SettingService $service)
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    protected function getIndexUrl(): string
    {
        return route('admin.setting.index');
    }
}
