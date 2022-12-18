<?php

namespace App\Admin\Controllers\Loyalty;

use App\Admin\Services\Loyalty\LoyaltyAdminService;
use App\Http\Controllers\Controller;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use App\Exceptions\WrongArgumentException;
use Illuminate\Http\Response;
use Encore\Admin\Controllers\HasResourceActions;

/**
 * Class LoyaltyController
 * @package App\Admin\Controllers\Loyalty
 */
class LoyaltyController extends Controller
{
    use HasResourceActions;

    private const PAGE_HEADER = 'Акции';

    /**
     * @var LoyaltyAdminService
     */
    private $service;

    /**
     * LoyaltyController constructor.
     * @param LoyaltyAdminService $service
     */
    public function __construct(LoyaltyAdminService $service)
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
     * @param int $id
     * @param Content $content
     * @return Content
     */
    public function show(int $id, Content $content): Content
    {
        $type = request()->get('type');

        return $content
            ->header(self::PAGE_HEADER)
            ->description('Детали')
            ->breadcrumb(
                ['text' => 'Список', 'url' => route('admin.loyalty-program.loyalties.list')],
                ['text' => 'Детали Акции']
            )
        ->row($this->service->getTabsContent($id, $type))
        ->row($this->service->getDetailPageContent($id, $type));
    }

    /**
     * Обработка изменений в селектах. Статусы, причины отказов
     *
     * @param int $id
     * @param int $entityId
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function loyaltyEntityChangeStatus(int $id, int $entityId, Request $request): Response
    {
        try {
            if ($request->get('status')) {
                $this->service->changeLoyaltyUserStatus($id, $entityId, $request->get('status'));
            } elseif ($request->get('proposal_status')) {
                $this->service->changeUserProposalStatus($id, $entityId, $request->get('proposal_status'));
            } elseif ($request->get('name') === 'loyalty_proposal_cancel_reason_id') {
                $this->service->changeUserProposalCancelReason($id, $entityId, $request->get('value'));
            } elseif ($request->get('name') === 'accrue_points') {
                $this->service->accrueLoyaltyPoints($entityId, $request->get('value'));
            }

            return response([
                'message' => 'Данные успешно обновлены',
                'status' => true,
            ]);
        } catch (WrongArgumentException $exception) {
            return response([
                'message' => $exception->getMessage(),
                'status' => false,
            ]);
        }
    }

    /**
     * @param int $id
     * @param int $proposalId
     * @param Content $content
     * @return Content
     */
    public function editProposal(int $id, int $proposalId, Content $content): Content
    {
        return $content
            ->header(self::PAGE_HEADER)
            ->description('Редактирование заявки')
            ->breadcrumb(
                ['text' => 'Список', 'url' => route('admin.loyalty-program.loyalties.show', ['id' => $id])],
                ['text' => 'Редактирование']
            )->body($this->form()->edit($proposalId));
    }

    /**
     * Для работы трэйта HasResourceActions при выносе формирования формы из контролера.
     *
     * @return Form
     */
    protected function form(): Form
    {
        return $this->service->getProposalFormContent();
    }
}
