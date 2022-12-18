<?php

namespace App\Http\Controllers;

use App\Domain\ServiceContracts\Project\ProjectServiceContract;
use App\Domain\ServiceContracts\Project\ProjectAttributeServiceContract;
use App\Domain\ServiceContracts\Project\ProjectStatusServiceContract;
use App\Domain\ServiceContracts\Project\ProjectSpecificationServiceContract;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\View\View;

/**
 * Class ProjectController
 * @package App\Http\Controllers
 */
class ProjectController extends BaseFrontController
{
    /**
     * @var ProjectServiceContract
     */
    private $service;

    /**
     * @var ProjectAttributeServiceContract
     */
    private $attributeService;

    /**
     * @var ProjectStatusServiceContract
     */
    private $statusService;

    /**
     * @var ProjectSpecificationServiceContract
     */
    private $specificationService;

    private $project;

    /**
     * ProjectController constructor.
     * @param ProjectServiceContract $service
     * @param ProjectAttributeServiceContract $attributeService
     * @param ProjectStatusServiceContract $statusService
     * @param ProjectSpecificationServiceContract $specificationService
     */
    public function __construct(
        ProjectServiceContract $service,
        ProjectAttributeServiceContract $attributeService,
        ProjectStatusServiceContract $statusService,
        ProjectSpecificationServiceContract $specificationService)
    {
        $this->service = $service;
        $this->attributeService = $attributeService;
        $this->statusService = $statusService;
        $this->specificationService = $specificationService;
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function list(): View
    {
        $this->authorize('list', $this->service->getRepository()->getSource());

        $projects = $this->service->getUserProjectsList();
        $statuses = $this->statusService->getStatusesList();

        $breadcrumbs = [
            [
                'title' => trans('project.list'),
            ],
        ];

        return view('project.list', [
            'breadcrumbs' => $breadcrumbs,
            'projects' => $projects,
            'statuses' => $statuses,
        ]);
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', $this->service->getRepository()->getSource());

        $attributes = $this->attributeService->getAttributesList();
        $statuses = $this->statusService->getStatusesList();

        $breadcrumbs = [
            [
                'title' => trans('project.list'),
                'url' => route('project.list'),
            ],
            [
                'title' => trans('project.create'),
            ],
        ];

        return view('project.form', [
            'breadcrumbs' => $breadcrumbs,
            'attributes' => $attributes,
            'statuses' => $statuses,
        ]);
    }

    /**
     * @param int $projectId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function details(int $projectId)
    {
        if ($this->service->getOwnerPermission($projectId) === false) {
            return redirect(route('project.list'));
        }

        $this->processingProjectPage($projectId);

        $breadcrumbs = [
            [
                'title' => trans('project.list'),
                'url' => route('project.list'),
            ],
            [
                'title' => trans('project.details', ['title' => $this->project['title']]),
            ],
        ];

        return view('project.details', [
            'breadcrumbs' => $breadcrumbs,
            'project' => $this->project,
        ]);
    }

    /**
     * @param int $projectId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function update(int $projectId)
    {
        if ($this->service->getOwnerPermission($projectId) === false) {
            return redirect(route('project.list'));
        }

        $this->processingProjectPage($projectId);

        $attributes = $this->attributeService->getAttributesList();
        $statuses = $this->statusService->getStatusesList();

        $breadcrumbs = [
            [
                'title' => trans('project.list'),
                'url' => route('project.list'),
            ],
            [
                'title' => trans('project.update', ['title' => $this->project['title']]),
            ],
        ];

        return view('project.form', [
            'breadcrumbs' => $breadcrumbs,
            'attributes' => $attributes,
            'statuses' => $statuses,
            'project' => $this->project,
        ]);
    }

    /**
     * @param int $projectId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function products(int $projectId)
    {
        if ($this->service->getOwnerPermission($projectId) === false) {
            return redirect(route('project.list'));
        }

        $this->processingProjectPage($projectId);

        $projectCategories = $this->service->getCategoriesList($projectId);

        $breadcrumbs = [
            [
                'title' => trans('project.list'),
                'url' => route('project.list'),
            ],
            [
                'title' => trans('project.products', ['title' => $this->project['title']]),
            ],
        ];

        return view('project.products', [
            'breadcrumbs' => $breadcrumbs,
            'project' => $this->project,
            'projectCategories' => $projectCategories,
        ]);
    }

    /**
     * @param int $projectId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function specifications(int $projectId)
    {
        if ($this->service->getOwnerPermission($projectId) === false) {
            return redirect(route('project.list'));
        }

        $this->processingProjectPage($projectId);

        $specifications = $this->service->getProjectSpecifications($projectId);
        if (empty($specifications)) {
            $specifications = $this->service->createProjectSpecification($projectId);
        }

        $breadcrumbs = [
            [
                'title' => trans('project.list'),
                'url' => route('project.list'),
            ],
            [
                'title' => trans('project.specifications', ['title' => $this->project['title']]),
            ],
        ];

        return view('project.specifications', [
            'breadcrumbs' => $breadcrumbs,
            'project' => $this->project,
            'specification' => $specifications,
        ]);
    }

    /**
     * @param int $projectId
     */
    private function processingProjectPage(int $projectId): void
    {
        $this->service->addCurrentUserActivity($projectId);
        $this->project = $this->service->getProjectDetails($projectId);
    }
}
