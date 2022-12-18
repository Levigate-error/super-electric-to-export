<?php

namespace App\Http\Controllers\Api;

use App\Domain\ServiceContracts\ProductDivisionServiceContract;
use App\Http\Requests\ProductDivisionRequest;

/**
 * Class ProductDivisionController
 * @package App\Http\Controllers\Api
 */
class ProductDivisionController extends BaseApiController
{
    /**
     * @apiDefine ResponseProductDivision
     * @apiSuccess  {integer}    product_division.id     Идентификатор
     * @apiSuccess  {string}     product_division.name   Название
     * @apiSuccess  {string}     product_division.image  Изображение
     */

    /**
     * @var ProductDivisionServiceContract
     */
    private $service;

    /**
     * ProductDivisionController constructor.
     *
     * @param ProductDivisionServiceContract $service
     */
    public function __construct(ProductDivisionServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @api            {get} api/catalog/product-divisions Список признаков изделия
     * @apiName        ProductDivisionList
     * @apiGroup       Catalog
     * @apiDescription Возвращает список признаков изделия
     *
     * @apiParam  {integer}    [category]  ID товарной группы
     * @apiParam  {integer}    [family]    ID серии
     *
     * @apiSuccess     {Array} data
     * @apiUse    ResponseProductDivision
     *
     * @param ProductDivisionRequest $request
     *
     * @return mixed
     */
    public function listByParams(ProductDivisionRequest $request)
    {
        return $this->service->getListByParams($request->validated());
    }
}
