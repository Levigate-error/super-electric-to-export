<?php

namespace App\Admin\Controllers\User;

use App\Admin\Services\User\Imports\Avito\AvitoUserImportService;
use App\Admin\Services\User\UserService;
use App\Admin\Controllers\BaseController;
use Encore\Admin\Layout\Content;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Throwable;

/**
 * Class UserController
 * @package App\Admin\Controllers\User
 */
class UserController extends BaseController
{
    protected const PAGE_HEADER = 'Пользователи';
    protected const PAGE_DESCRIPTION_IMPORT = 'Импорт';

    /**
     * @var UserService
     */
    protected $service;

    /**
     * UserController constructor.
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Content $content
     *
     * @return Content
     */
    public function formImport(Content $content): Content
    {
        return $content
            ->header(static::PAGE_HEADER)
            ->description(static::PAGE_DESCRIPTION_IMPORT)
             ->breadcrumb(
                 ['text' => 'Список', 'url' => $this->getIndexUrl()],
                 ['text' => static::PAGE_DESCRIPTION_IMPORT]
             )
            ->body($this->service->getImportFormContent());
    }

    /**
     * Импорт пользоватлей.
     *
     * @param Request                $request
     * @param AvitoUserImportService $userImportService
     *
     * @return RedirectResponse|Redirector
     */
    public function import(Request $request, AvitoUserImportService $userImportService)
    {
        $message = $this->service->getImportFormContent()->validate($request);

        if ($message !== false) {
            return back()->withInput()->withErrors($message);
        }

        try {
            $importResult = $userImportService->run($request->file('file'));
            admin_toastr($importResult->message());
        } catch (Throwable $exception) {
            admin_toastr(__('admin.imports.import_failed'), 'error');
            return redirect($this->getIndexUrl());
        }

        return redirect($this->getIndexUrl());
    }

    /**
     * {@inheritDoc}
     */
    protected function getIndexUrl(): string
    {
        return route('admin.users.list');
    }
}
