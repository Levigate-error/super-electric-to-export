<?php

namespace App\Http\Controllers\Api;

use App\Domain\ServiceContracts\ProductFamilyServiceContract;
use App\Http\Requests\ProductFamilyRequest;

/**
 * Class ProductFamilyController
 * @package App\Http\Controllers\Api
 */
class ProductFamilyController extends BaseApiController
{
    /**
     * @apiDefine ResponseProductFamily
     * @apiSuccess  {integer}    product_family.id     Идентификатор
     * @apiSuccess  {string}     product_family.name   Название
     * @apiSuccess  {string}     product_family.code   Код
     * @apiSuccess  {string}     product_family.number Номер
     */

    /**
     * @var ProductFamilyServiceContract
     */
    private $service;

    /**
     * ProductFamilyController constructor.
     *
     * @param ProductFamilyServiceContract $service
     */
    public function __construct(ProductFamilyServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @api            {get} api/catalog/product-families Список серий
     * @apiName        ProductFamilyList
     * @apiGroup       Catalog
     * @apiDescription Возвращает список серий
     *
     * @apiParam  {integer}    [category]    ID товарной группы
     * @apiParam  {integer}    [division]    ID признака изделия
     *
     * @apiSuccess     {Array} data
     * @apiUse    ResponseProductFamily
     *
     * @param ProductFamilyRequest $request
     *
     * @return mixed
     */
    public function listByParams(ProductFamilyRequest $request)
    {
        return $this->service->getListByParams($request->validated());
    }
}
