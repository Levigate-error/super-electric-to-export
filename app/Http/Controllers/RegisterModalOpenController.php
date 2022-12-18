<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Domain\ServiceContracts\Project\ProjectServiceContract;
use App\Domain\ServiceContracts\ProductCategoryServiceContract;

/**
 * Class RegisterModalOpenController
 * @package App\Http\Controllers
 */
class RegisterModalOpenController extends BaseFrontController
{
    /**
     *
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
                'openRegModal' => true,
                'csrf' => csrf_token(),
                'recaptcha' => config('recaptcha.google-recaptcha-site-key'),
                'projects' => $projectService->getUserProjectsList(['limit' => 3]),
            ],
        ]);
    }
}
