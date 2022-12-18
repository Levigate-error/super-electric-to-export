<?php

namespace App\Admin\Controllers\Loyalty;

use App\Admin\Services\Loyalty\LoyaltyProductCodeAdminService;
use App\Http\Controllers\Controller;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\HasResourceActions;

/**
 * Class LoyaltyProductCodeController
 * @package App\Admin\Controllers\Loyalty
 */
class LoyaltyProductCodeController extends Controller
{
    use HasResourceActions;

    private const PAGE_HEADER = 'Коды продуктов';

    /**
     * @var LoyaltyProductCodeAdminService
     */
    private $service;

    /**
     * LoyaltyProductCodeController constructor.
     * @param LoyaltyProductCodeAdminService $service
     */
    public function __construct(LoyaltyProductCodeAdminService $service)
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
                ['text' => 'Список', 'url' => route('admin.loyalty-program.settings.product-codes.list')],
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
            admin_error('Этот код нельзя редактировать.');
            return back();
        }

        return $content
            ->header(self::PAGE_HEADER)
            ->description('Редактирование')
            ->breadcrumb(
                ['text' => 'Список', 'url' => route('admin.loyalty-program.settings.product-codes.list')],
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
                'message' => 'Этот код нельзя удалить.',
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
