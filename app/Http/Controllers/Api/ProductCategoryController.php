<?php

namespace App\Http\Controllers\Api;

use App\Domain\ServiceContracts\ProductCategoryServiceContract;

/**
 * Class ProductCategoryController
 * @package App\Http\Controllers\Api
 */
class ProductCategoryController extends BaseApiController
{
    /**
     * @apiDefine ResponseProductCategory
     * @apiSuccess  {integer}    product_category.id    Идентификатор
     * @apiSuccess  {string}     product_category.name  Название
     * @apiSuccess  {string}     product_category.image Изображение
     */

    /**
     * @var ProductCategoryServiceContract
     */
    private $service;

    /**
     * ProductCategoryController constructor.
     *
     * @param ProductCategoryServiceContract $service
     */
    public function __construct(ProductCategoryServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @api            {get} api/catalog/product-categories Список категорий
     * @apiName        ProductCategoryList
     * @apiGroup       Catalog
     * @apiDescription Возвращает список категорий
     *
     * @apiSuccess     {Array} data
     * @apiUse    ResponseProductCategory
     *
     * @return mixed
     */
    public function list()
    {
        return $this->service->getList();
    }
}
