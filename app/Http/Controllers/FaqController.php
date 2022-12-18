<?php

namespace App\Http\Controllers;

use App\Domain\ServiceContracts\FaqServiceContract;
use Illuminate\View\View;

/**
 * Class FaqController
 * @package App\Http\Controllers
 */
class FaqController extends BaseFrontController
{
    /**
     * @var FaqServiceContract
     */
    private $service;

    /**
     * FaqController constructor.
     * @param FaqServiceContract $service
     */
    public function __construct(FaqServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('index', $this->service->getRepository()->getSource());

        $breadcrumbs = [
            [
                'title' => trans('faq.index'),
            ],
        ];

        return view('faq.index', [
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}



