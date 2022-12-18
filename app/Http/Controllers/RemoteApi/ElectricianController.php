<?php

namespace App\Http\Controllers\RemoteApi;

use App\Domain\ServiceContracts\User\UserServiceContract;

/**
 * Class ElectricianController
 * @package App\Http\Controllers\RemoteApi
 */
class ElectricianController extends BaseRemoteApiController
{
    /**
     * @var UserServiceContract
     */
    private $service;

    /**
     * ElectricianController constructor.
     * @param UserServiceContract $service
     */
    public function __construct(UserServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Метод для получения списка опубликованных электриков с данными по активной программе лояльности
     *
     * @return mixed
     */
    public function getList()
    {
        return $this->service->getPublishedElectrician();
    }
}
