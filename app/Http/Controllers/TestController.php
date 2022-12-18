<?php

namespace App\Http\Controllers;

use App\Domain\ServiceContracts\Test\TestServiceContract;
use Illuminate\View\View;
use Illuminate\Auth\Access\AuthorizationException;

/**
 * Class TestController
 * @package App\Http\Controllers
 */
class TestController extends BaseFrontController
{
    /**
     * @var TestServiceContract
     */
    private $service;

    /**
     * TestController constructor.
     * @param TestServiceContract $service
     */
    public function __construct(TestServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('index', $this->service->getRepository()->getSource());

        $breadcrumbs = [
            [
                'title' => trans('test.index'),
            ],
        ];

        return view('test.index', [
            'breadcrumbs' => $breadcrumbs,
            'tests' => $this->service->getTests(),
        ]);
    }

    /**
     * @param int $id
     * @return View
     * @throws AuthorizationException
     */
    public function show(int $id): View
    {
        $this->authorize('show', $this->service->getRepository()->getSource());

        $test = $this->service->getTest($id);

        $breadcrumbs = [
            [
                'title' => trans('test.index'),
                'url' => route('test.index'),
            ],
            [
                'title' => trans('test.details', ['title' => $test['title']]),
            ],
        ];

        return view('test.show', [
            'breadcrumbs' => $breadcrumbs,
            'test' => $test,
        ]);
    }
}



