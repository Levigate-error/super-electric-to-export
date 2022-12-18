<?php

namespace App\Http\Controllers\Api;

use App\Domain\ServiceContracts\BannerServiceContract;

/**
 * Class BannerController
 * @package App\Http\Controllers\Api
 */
class BannerController extends BaseApiController
{
    /**
     * @var BannerServiceContract
     */
    private $service;

    /**
     * BannerController constructor.
     * @param BannerServiceContract $service
     */
    public function __construct(BannerServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @api            {get} api/banner Список баннеров
     * @apiName        BannerList
     * @apiGroup       Banner
     * @apiDescription Возвращает список баннеров
     *
     * @apiSuccess  {array}     banners                  Города
     * @apiSuccess  {integer}   banners.id               ID
     * @apiSuccess  {string}    banners.title            Название
     * @apiSuccess  {string}    banners.url              Ссылка
     * @apiSuccess  {array}     banners.images           Изображения
     * @apiSuccess  {integer}   banners.images.id        ID
     * @apiSuccess  {string}    banners.images.size      Размер
     * @apiSuccess  {string}    banners.images.path      Путь
     *
     * @return array
     */
    public function list(): array
    {
        return $this->service->getListForCurrentUser();
    }
}
