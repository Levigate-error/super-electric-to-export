<?php

namespace App\Admin\Controllers\Product;

use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\HasResourceActions;
use App\Admin\Controllers\BaseController;
use App\Admin\Services\Product\ProductCategoryService;

/**
 * Class ProductCategoriesController
 * @package App\Admin\Controllers\Product
 */
class ProductCategoriesController extends BaseController
{
    use HasResourceActions;

    protected const PAGE_HEADER = 'Товарные группы';

    /**
     * @var ProductCategoryService
     */
    public $service;

    /**
     * ProductCategoriesController constructor.
     * @param ProductCategoryService $service
     */
    public function __construct(ProductCategoryService $service)
    {
        $this->service = $service;
    }

    /**
     * @param int $id
     * @param Content $content
     * @return Content
     */
    public function edit(int $id, Content $content): Content
    {
        $content = parent::edit($id, $content);

        return $content->breadcrumb(
            [
                'text' => static::PAGE_DESCRIPTION_LIST,
                'url' => route('admin.catalog.product-categories.index')
            ],
            [
                'text' => static::PAGE_DESCRIPTION_EDIT
            ]
        );
    }

    /**
     * @param int $id
     * @param Content $content
     * @return Content
     */
    public function show(int $id, Content $content): Content
    {
        $content = parent::show($id, $content);

        return $content->breadcrumb(
            [
                'text' => static::PAGE_DESCRIPTION_LIST,
                'url' => route('admin.catalog.product-categories.index')
            ],
            [
                'text' => static::PAGE_DESCRIPTION_DETAILS
            ]
        );
    }
}
