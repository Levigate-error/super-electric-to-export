<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Domain\ServiceContracts\ProductCategoryServiceContract;
use App\Domain\ServiceContracts\Project\ProjectServiceContract;

/**
 * Class IndexController
 * @package App\Http\Controllers
 */
class IndexController extends BaseFrontController
{
     /**
     * @param ProductCategoryServiceContract $categoryService
     * @param ProjectServiceContract $projectService
     * @return View
     */
    public function index(ProductCategoryServiceContract $categoryService, ProjectServiceContract $projectService): View
    {
        $productCategories = $categoryService->getToMainPage()->resolve();

        return view('index', [
            'data' => [
                'categories' => $productCategories,
                'projects' => $projectService->getUserProjectsList(['limit' => 3]),
            ],
        ]);
    }
}



