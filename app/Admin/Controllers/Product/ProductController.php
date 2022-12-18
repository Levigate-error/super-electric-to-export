<?php

namespace App\Admin\Controllers\Product;

use App\Admin\Controllers\BaseController;
use App\Admin\Services\Product\ProductService;

/**
 * Class ProductController
 * @package App\Admin\Controllers\Product
 */
class ProductController extends BaseController
{
    protected const PAGE_HEADER = 'Товары';

    /**
     * @var ProductService
     */
    protected $service;

    /**
     * ProductController constructor.
     * @param ProductService $service
     */
    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }
}
