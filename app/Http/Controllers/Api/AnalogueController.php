<?php

namespace App\Http\Controllers\Api;

use Illuminate\Auth\Access\AuthorizationException;
use App\Domain\ServiceContracts\AnalogueServiceContract;
use App\Http\Requests\AnalogSearchRequest;

/**
 * Class AnalogueController
 * @package App\Http\Controllers\Api
 */
class AnalogueController extends BaseApiController
{
    /**
     * @apiDefine   ResponseAnalogs
     *
     * @apiSuccess  {array}     analogues                             Аналоги
     * @apiSuccess  {integer}   analogues.id                          Идентификатор
     * @apiSuccess  {string}    analogues.vendor                      Производитель
     * @apiSuccess  {string}    analogues.vendor_code                 Артикул
     * @apiSuccess  {string}    analogues.description                 Описание
     * @apiSuccess  {array}     analogues.products                    Товары
     */

    /**
     * @var AnalogueServiceContract
     */
    private $service;

    /**
     * AnalogueController constructor.
     * @param AnalogueServiceContract $service
     */
    public function __construct(AnalogueServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @api            {post} api/analog/search Поиск аналога
     * @apiName        AnalogSearch
     * @apiGroup       Analog
     * @apiDescription Ищет аналог по артикулу
     *
     * @apiParam  {string}   vendor_code    Артикул
     *
     * @apiUse    ResponseAnalogs
     *
     * @param AnalogSearchRequest $request
     * @return mixed
     * @throws AuthorizationException
     */
    public function search(AnalogSearchRequest $request)
    {
        $this->authorize('search', $this->service->getRepository()->getSource());

        return $this->service->search($request->validated());
    }
}
