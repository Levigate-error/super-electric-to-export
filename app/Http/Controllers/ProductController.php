<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Domain\ServiceContracts\ProductServiceContract;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends BaseFrontController
{
    /**
     * @param int $productId
     * @param ProductServiceContract $service
     * @return View
     */
    public function detail(int $productId, ProductServiceContract $service): View
    {
        $product = $service->getProductDetails($productId)->resolve();

        $breadcrumbs = [
            [
                'title' => trans('menu.catalog'),
                'url' => route('catalog.index'),
            ],
            [
                'title' => $product['category']['name'],
                'url' => route('catalog.index', [
                    'category_id' => $product['category']['id']
                ]),
            ],
            [
                'title' => $product['division']['name'],
                'url' => route('catalog.index', [
                    'category_id' => $product['category']['id'],
                    'division_id' => $product['division']['id'],
                ]),
            ],
            [
                'title' => $product['family']['name'],
                'url' => route('catalog.index', [
                    'division_id' => $product['division']['id'],
                    'category_id' => $product['category']['id'],
                    'family_id' => $product['family']['id'],
                ]),
            ],
            [
                'title' => $product['name'],
            ],
        ];

        return view('catalog.product', [
            'product' => $product,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}
