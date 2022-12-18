<?php

namespace App\Http\Controllers\Api;

use App\Domain\ServiceContracts\ProductFeatureServiceContract;
use App\Http\Requests\ProductFeatureRequest;

/**
 * Class ProductFeatureController
 * @package App\Http\Controllers\Api
 */
class ProductFeatureController extends BaseApiController
{
    /**
     * @apiDefine ResponseProductFilters
     * @apiSuccess  {integer}   type.id            Идентификатор
     * @apiSuccess  {string}    type.name          Название
     * @apiSuccess  {array}     type.values        Значения
     * @apiSuccess  {integer}   type.values.id     Значения
     * @apiSuccess  {string}    type.values.value  Значения
     * @apiSuccess  {string}    type.values.product_count  Кол-ство товаров с таким значением фильтра
     */

    /**
     * @var ProductFeatureServiceContract
     */
    private $service;

    /**
     * ProductFeatureController constructor.
     *
     * @param ProductFeatureServiceContract $service
     */
    public function __construct(ProductFeatureServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @api            {get} api/catalog/filters Список фильтров
     * @apiName        FilterList
     * @apiGroup       Catalog
     * @apiDescription Возвращает список фильтров
     *
     * @apiParam  {integer}    [category]    ID товарной группы
     * @apiParam  {integer}    [division]    ID признака изделия
     * @apiParam  {integer}    [family]      ID серии
     *
     * @apiSuccess     {Array} data
     * @apiUse    ResponseProductFilters
     *
     * @param ProductFeatureRequest $request
     *
     * @return mixed
     */
    public function getFilters(ProductFeatureRequest $request)
    {
        return $this->service->getFiltersByParams($request->validated());
    }
}
