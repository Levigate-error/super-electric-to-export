<?php

namespace App\Admin\Controllers;

use App\Admin\Services\CertificateAdminService;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;

/**
 * Class CertificateController
 * @package App\Admin\Controllers
 */
class CertificateController extends Controller
{
    use HasResourceActions;

    private const PAGE_HEADER = 'Сертификаты';

    /**
     * @var CertificateAdminService
     */
    private $service;

    /**
     * CertificateController constructor.
     * @param CertificateAdminService $service
     */
    public function __construct(CertificateAdminService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content): Content
    {
        return $content
            ->header(self::PAGE_HEADER)
            ->description('Список')
            ->body($this->service->getCrudPageContent());
    }

    /**
     * @param Content $content
     * @return Content
     */
    public function create(Content $content): Content
    {
        return $content
            ->header(self::PAGE_HEADER)
            ->description('Добавление')
            ->breadcrumb(
                ['text' => 'Список', 'url' => route('admin.loyalty-program.settings.certificates.list')],
                ['text' => 'Добавление']
            )->body($this->form());
    }

    /**
     * @param int $id
     * @param Content $content
     * @return Content|\Illuminate\Http\RedirectResponse
     */
    public function edit(int $id, Content $content)
    {
        if ($this->service->checkEditPossibility($id) === false) {
            admin_error('Этот сертификат нельзя редактировать.');
            return back();
        }

        return $content
            ->header(self::PAGE_HEADER)
            ->description('Редактирование')
            ->breadcrumb(
                ['text' => 'Список', 'url' => route('admin.loyalty-program.settings.certificates.list')],
                ['text' => 'Редактирование']
            )->body($this->form()->edit($id));
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function delete(int $id)
    {
        if ($this->service->checkDeletePossibility($id) === false) {
            $response = [
                'status'  => false,
                'message' => 'Этот сертификат нельзя удалить.',
            ];

            return response()->json($response);
        }

        return $this->destroy($id);
    }

    /**
     * Для работы трэйта HasResourceActions при выносе формирования формы из контролера.
     *
     * @return Form
     */
    protected function form()
    {
        return $this->service->getFormContent();
    }
}
