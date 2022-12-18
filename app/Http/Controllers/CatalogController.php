<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Domain\ServiceContracts\ProductCategoryServiceContract;

/**
 * Class CatalogController
 * @package App\Http\Controllers
 */
class CatalogController extends BaseFrontController
{
    /**
     * @param ProductCategoryServiceContract $categoryService
     * @param Request $request
     * @return View
     */
    public function index(ProductCategoryServiceContract $categoryService, Request $request): View
    {
        $categories = $categoryService->getList()->resolve();

        $breadcrumbs = [
            [
                'title' => trans('menu.catalog'),
            ],
        ];

        return view('catalog.index', [
            'data' => [
                'categories' => $categories,
                'selected_category_id' => $request->get('category_id'),
                'selected_division_id' => $request->get('division_id'),
                'selected_family_id' => $request->get('family_id'),
            ],
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}
