<?php

namespace App\Http\Controllers\Api;

use App\Domain\ServiceContracts\CityServiceContract;
use App\Http\Requests\CitySearchRequest;

/**
 * Class CityController
 * @package App\Http\Controllers\Api
 */
class CityController extends BaseApiController
{
    /**
     * @var CityServiceContract
     */
    private $service;

    /**
     * CityController constructor.
     * @param CityServiceContract $service
     */
    public function __construct(CityServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @api            {post} api/city/search Поиск города
     * @apiName        CitySearch
     * @apiGroup       City
     * @apiDescription Ищет город по названию
     *
     * @apiParam  {string}   title    Название
     *
     * @apiSuccess  {array}     cities             Города
     * @apiSuccess  {integer}   cities.id          ID
     * @apiSuccess  {string}    cities.title       Название
     *
     * @param CitySearchRequest $request
     * @return array
     */
    public function search(CitySearchRequest $request): array
    {
        return $this->service->search($request->validated());
    }
}
