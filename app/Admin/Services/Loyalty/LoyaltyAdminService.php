<?php

namespace App\Admin\Services\Loyalty;

use App\Admin\Actions\Loyalty\AddPoints;
use App\Admin\Actions\Loyalty\RecountPoints;
use App\Admin\Extensions\LoyaltyProposalExporter;
use Encore\Admin\Form;
use Encore\Admin\Grid\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use App\Exceptions\WrongArgumentException;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Grid\Displayers\Actions;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Show\Tools;
use App\Admin\Services\BaseService;
use App\Domain\ServiceContracts\Loyalty\LoyaltyServiceContract;
use App\Domain\ServiceContracts\Loyalty\LoyaltyUserServiceContract;
use App\Domain\ServiceContracts\Loyalty\LoyaltyUserProposalServiceContract;
use App\Domain\ServiceContracts\Loyalty\LoyaltyProductCodeServiceContract;
use App\Models\Loyalty\Loyalty;
use App\Models\Loyalty\LoyaltyUser;
use App\Models\Loyalty\LoyaltyUserProposal;
use App\Models\Loyalty\LoyaltyUserPoint;
use App\Domain\Dictionaries\Loyalty\LoyaltyUserStatuses;
use App\Domain\Dictionaries\Loyalty\LoyaltyUserProposalStatuses;
use App\Models\Loyalty\LoyaltyProposalCancelReason;
use App\Exceptions\CanNotSaveException;
use App\Admin\Extensions\LoyaltyStandingExporter;
use App\Domain\Repositories\Loyalty\LoyaltyUserProposalRepositoryContract;

/**
 * Class LoyaltyAdminService
 *
 * @package App\Admin\Services\Loyalty
 */
class LoyaltyAdminService extends BaseService
{
    /**
     * @var LoyaltyServiceContract
     */
    private $service;

    private $proposalRepository;

    /**
     * LoyaltyAdminService constructor.
     *
     * @param LoyaltyServiceContract $service
     */
    public function __construct(LoyaltyServiceContract $service, LoyaltyUserProposalRepositoryContract $proposalRepository)
    {
        $this->service = $service;
        $this->proposalRepository = $proposalRepository;
    }

    /**
     * @return Grid
     */
    public function getCrudPageContent(): Grid
    {
        $grid = new Grid(new Loyalty());

        $grid->disableFilter();
        $grid->disableRowSelector();
        $grid->disableExport();
        $grid->disableCreateButton();

        $grid->actions(function (Actions $actions) {
            $actions->disableEdit();
            $actions->disableDelete();
        });

        $grid->model()->orderBy('id', 'desc');

        $grid->id('ID')->sortable();
        $grid->title('Название');
        $grid->started_at('Дата начала');
        $grid->ended_at('Дата завершения');
        $grid->active('Активно')->display(function () {
            return ($this->active === true) ? 'Да' : 'Нет';
        });

        return $grid;
    }

    /**
     * @param int         $loyaltyId
     * @param string|null $type
     *
     * @return Tab
     */
    public function getTabsContent(int $loyaltyId, ?string $type = null): Tab
    {
        $type = $type ?? LoyaltyAdminMenuMapper::DEFAULT_TYPE;
        $menuItems = LoyaltyAdminMenuMapper::getMap();

        $tab = new Tab();

        foreach ($menuItems as $menuItem) {
            $isActive = $menuItem['type'] === $type;
            $link = route('admin.loyalty-program.loyalties.show', ['id' => $loyaltyId]) . '?type=' . $menuItem['type'];

            $tab->addLink($menuItem['title'], $link, $isActive);
        }

        return $tab;
    }

    /**
     * @param int         $id
     * @param string|null $type
     *
     * @return mixed|string
     */
    public function getDetailPageContent(int $id, ?string $type = null)
    {
        $type = $type ?? LoyaltyAdminMenuMapper::DEFAULT_TYPE;
        $loyalty = Loyalty::findOrFail($id);

        $method = $this->getDetailMethodByType($type);

        if (method_exists($this, $method) === false) {
            return 'Метод [' . $method . '] не найден в ' . self::class;
        }

        return $this->{$method}($loyalty);
    }

    /**
     * @param string $type
     *
     * @return string
     */
    protected function getDetailMethodByType(string $type): string
    {
        return "get{$type}Details";
    }

    /**
     * @param Loyalty $loyalty
     *
     * @return Grid
     */
    protected function getLoyaltyStandingsDetails(Loyalty $loyalty): Grid
    {
        $grid = new Grid(new LoyaltyUserPoint());

        $grid->disableActions();
        $grid->disableFilter();
        $grid->disableCreateButton();
        $grid->disableColumnSelector();
        $grid->exporter(new LoyaltyStandingExporter());

        $grid->model()->orderBy('points', 'desc');
        $grid->model()->whereHas('loyaltyUser', static function (Builder $userBuilder) use ($loyalty) {
            return $userBuilder->where(['loyalty_users.loyalty_id' => $loyalty->id]);
        });

        $grid->column('user_last_name', 'Фамилия')->display(function () {
            return $this->loyaltyUser->user->last_name;
        });

        $grid->column('user_first_name', 'Имя')->display(function () {
            return $this->loyaltyUser->user->first_name;
        });

        $grid->column('user_phone', 'Телефон')->display(function () {
            return $this->loyaltyUser->user->phone;
        });

        $grid->column('user_email', 'E-mail')->display(function () {
            return $this->loyaltyUser->user->email;
        });

        $grid->column('user_city', 'Город')->display(function () {
            $user = $this->loyaltyUser->user;

            if ($user->city_id === null) {
                return '-';
            }

            return translate_field($user->city->title);
        });

        $grid->points('Кол-во баллов');

        $grid->place('Место');

        $grid->batchActions(function ($batch) {
            $batch->add(new AddPoints());
            $batch->add(new RecountPoints());
            $batch->disableDelete();
        });

        return $grid;
    }

    /**
     * @param Loyalty $loyalty
     *
     * @return Grid
     */
    protected function getLoyaltyProposalsDetails(Loyalty $loyalty): Grid
    {
        $grid = new Grid(new LoyaltyUserProposal());

        $grid->exporter(new LoyaltyProposalExporter());
        $grid->disableActions();
        $grid->disableCreateButton();
        $grid->disableColumnSelector();

        $grid->model()->orderBy('id', 'desc');
        $grid->model()->whereHas('loyaltyUserPoint', static function (Builder $pointBuilder) use ($loyalty) {
            return $pointBuilder->whereHas('loyaltyUser', static function (Builder $userBuilder) use ($loyalty) {
                return $userBuilder->where(['loyalty_users.loyalty_id' => $loyalty->id]);
            });
        });

        $grid->column('id_and_date', '№/дата заявки')->display(function () {
            return $this->id . ' от ' . Carbon::make($this->created_at)->format('d.m.Y');
        });

        $grid->column('user_last_name', 'Фамилия')->display(function () {
            return $this->loyaltyUserPoint->loyaltyUser->user->last_name;
        });

        $grid->column('user_first_name', 'Имя')->display(function () {
            return $this->loyaltyUserPoint->loyaltyUser->user->first_name;
        });

        $grid->column('user_phone', 'Телефон')->display(function () {
            return $this->loyaltyUserPoint->loyaltyUser->user->phone;
        });

        $grid->column('user_email', 'E-mail')->display(function () {
            return $this->loyaltyUserPoint->loyaltyUser->user->email;
        });

        $grid->column('user_city', 'Город')->display(function () {
            $user = $this->loyaltyUserPoint->loyaltyUser->user;

            if ($user->city_id === null) {
                return '-';
            }

            return translate_field($user->city->title);
        });

        $grid->column('code', '№ кода');

        $grid->column('product_code', '№ кода в базе')->display(function () {
            return ($this->loyaltyProductCode !== null) ? $this->loyaltyProductCode->code : '';
        });

        $grid->column('proposal_status', 'Статус')->select(LoyaltyUserProposalStatuses::getToHumanResource());

        $grid->column('accrue_points', 'Начислить баллов')->editable();

        $reasons = LoyaltyProposalCancelReason::query()->get()->mapWithKeys(static function ($item) {
            return [$item['id'] => $item['value']];
        })->toArray();

        $selectReasons = array_merge([0 => ''], $reasons);

        $grid->column('loyalty_proposal_cancel_reason_id', 'Причина отказа')->editable('select', $selectReasons);

        $grid->filter(static function (Filter $filter) use ($reasons) {
            $filter->disableIdFilter();

            $filter->where(function (Builder $query) {
                $query->where('id', '=', $this->input);
            }, '№ заявки', 'number');

            $filter->date('created_at', 'Дата заявки');

            $filter->where(function (Builder $query) {
                $query->whereHas('loyaltyUserPoint.loyaltyUser.user', function (Builder $query) {
                    $query->where('first_name', 'ILIKE', "%{$this->input}%");
                });
            }, 'Имя', 'first_name');

            $filter->where(function (Builder $query) {
                $query->whereHas('loyaltyUserPoint.loyaltyUser.user', function (Builder $query) {
                    $query->where('last_name', 'ILIKE', "%{$this->input}%");
                });
            }, 'Фамилия', 'last_name');

            $filter->where(function (Builder $query) {
                $query->whereHas('loyaltyUserPoint.loyaltyUser.user', function (Builder $query) {
                    $query->where('phone', 'ILIKE', "%{$this->input}%");
                });
            }, 'Телефон', 'phone');

            $filter->where(function (Builder $query) {
                $query->whereHas('loyaltyUserPoint.loyaltyUser.user', function (Builder $query) {
                    $query->where('email', 'ILIKE', "%{$this->input}%");
                });
            }, 'E-mail', 'email');

            $filter->like('code', '№ кода');

            $filter->where(function (Builder $query) {
                $query->whereHas('loyaltyProductCode', function (Builder $query) {
                    $query->where('code', 'ILIKE', "%{$this->input}%");
                });
            }, '№ кода в базе', 'product_code');

            $filter->where(function ($query) {
                if ($this->input === 'all') {
                    return;
                }

                $query->where('proposal_status', '=', $this->input);
            }, 'Статус', 'proposal_status')
                ->select(array_merge(['all' => 'Все'], LoyaltyUserProposalStatuses::getToHumanResource()))
                ->default('all');


            $filter->where(function ($query) {
                if ($this->input === 'all') {
                    return;
                }

                $query->where('loyalty_proposal_cancel_reason_id', '=', $this->input);
            }, 'Причина отказа', 'loyalty_proposal_cancel_reason_id')
                ->select(array_merge(['all' => 'Все'], $reasons))
                ->default('all');
        });

        return $grid;
    }

    /**
     * @param Loyalty $loyalty
     *
     * @return Grid
     */
    protected function getLoyaltyUsersDetails(Loyalty $loyalty): Grid
    {
        $grid = new Grid(new LoyaltyUser());

        $grid->disableActions();
        $grid->disableFilter();
        $grid->disableRowSelector();
        $grid->disableCreateButton();
        $grid->disableColumnSelector();
        $grid->disableExport();

        $grid->model()->orderBy('id', 'desc');
        $grid->model()->where(['loyalty_id' => $loyalty->id]);

        $grid->column('id_and_date', '№/дата заявки')->display(function () {
            return $this->id . ' от ' . Carbon::make($this->created_at)->format('d.m.Y');
        });

        $grid->column('user_last_name', 'Фамилия')->display(function () {
            return $this->user->last_name;
        });

        $grid->column('user_first_name', 'Имя')->display(function () {
            return $this->user->first_name;
        });

        $grid->column('user_phone', 'Телефон')->display(function () {
            return $this->user->phone;
        });

        $grid->column('user_email', 'E-mail')->display(function () {
            return $this->user->email;
        });

        $grid->column('certificate_code', '№ сертификата')->display(function () {
            return $this->certificate 
                ? $this->certificate->code
                : '-';
        });

        $grid->column('status', 'Статус')->select(LoyaltyUserStatuses::getToHumanResource());

        return $grid;
    }

    /**
     * @param Loyalty $loyalty
     *
     * @return Show
     */
    protected function getLoyaltyDetails(Loyalty $loyalty): Show
    {
        $show = new Show($loyalty);

        $show->panel()
            ->tools(static function (Tools $tools) {
                $tools->disableEdit();
                $tools->disableList();
                $tools->disableDelete();
            });

        $show->id('ID');
        $show->title('Название');
        $show->started_at('Дата начала');
        $show->ended_at('Дата завершения');
        $show->active('Активно')->as(function ($active) {
            return ($active === true) ? 'Да' : 'Нет';
        });

        return $show;
    }

    /**
     * @param int    $loyaltyId
     * @param int    $userLoyaltyId
     * @param string $status
     *
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function changeLoyaltyUserStatus(int $loyaltyId, int $userLoyaltyId, string $status): bool
    {
        $loyaltyUserService = $this->getService(LoyaltyUserServiceContract::class);

        if (LoyaltyUserStatuses::checkExist($status) === false) {
            throw new WrongArgumentException("Статус [$status] у заявок на регистрацию не существует.");
        }

        $loyaltyUser = $loyaltyUserService->getRepository()->getById($userLoyaltyId);
        if ($loyaltyUser->loyalty_id !== $loyaltyId) {
            throw new WrongArgumentException("Заявка [$userLoyaltyId] не принадлежит акции [$loyaltyId]");
        }

        if ($loyaltyUser->status !== LoyaltyUserStatuses::NEW) {
            throw new WrongArgumentException('Только у заявки в статусе "Новая" можно изменить статус');
        }

        return $loyaltyUser->setStatus($status);
    }

    /**
     * @param int    $loyaltyId
     * @param int    $userProposalId
     * @param string $status
     *
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function changeUserProposalStatus(int $loyaltyId, int $userProposalId, string $status): bool
    {
        $loyaltyUserProposalService = $this->getService(LoyaltyUserProposalServiceContract::class);

        if (LoyaltyUserProposalStatuses::checkExist($status) === false) {
            throw new WrongArgumentException("Статус [$status] у заявок на регистрацию кода продутка не существует.");
        }

        $loyaltyUserProposal = $loyaltyUserProposalService->getRepository()->getById($userProposalId);
        if ($loyaltyUserProposal->loyaltyUserPoint->loyaltyUser->loyalty_id !== $loyaltyId) {
            throw new WrongArgumentException("Заявка [$userProposalId] не принадлежит акции [$loyaltyId]");
        }

        if (in_array(
            $loyaltyUserProposal->proposal_status,
            [LoyaltyUserProposalStatuses::NEW, LoyaltyUserProposalStatuses::PROCESSING],
            true
        ) === false) {
            throw new WrongArgumentException('Только у заявки в статусе "Новая" и "В обработке" можно изменить статус');
        }

        /**
         * Если пользователь вводил код, которого нет у нас в базе, но администратор нажимает одобрить,
         * то этот код должен попасть в базу и привязатся к этой заявке.
         */
        if ($status === LoyaltyUserProposalStatuses::APPROVED) {
            $productCodeService = $this->getService(LoyaltyProductCodeServiceContract::class);

            $productCode = $productCodeService->getProductCodeByCode($loyaltyUserProposal->code);

            if ($productCode->resource === null) {
                try {
                    $newProductCode = $productCodeService->createProductCode([
                        'code' => $loyaltyUserProposal->code,
                    ]);

                    if ($loyaltyUserProposal->setProductCode($newProductCode->resource) === false) {
                        throw new CanNotSaveException();
                    }
                } catch (CanNotSaveException $exception) {
                    throw new CanNotSaveException($exception->getMessage());
                }
            }
        }

        return $loyaltyUserProposal->setStatus($status);
    }

    /**
     * @param int $loyaltyId
     * @param int $userProposalId
     * @param int $cancelReason
     *
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function changeUserProposalCancelReason(int $loyaltyId, int $userProposalId, int $cancelReason): bool
    {
        $userProposalService = $this->getService(LoyaltyUserProposalServiceContract::class);

        $loyaltyUserProposal = $userProposalService->getRepository()->getById($userProposalId);
        if ($loyaltyUserProposal->loyaltyUserPoint->loyaltyUser->loyalty_id !== $loyaltyId) {
            throw new WrongArgumentException("Заявка [$userProposalId] не принадлежит акции [$loyaltyId]");
        }

        return $loyaltyUserProposal->setCancelReason($cancelReason);
    }

    /**
     * @return Form
     */
    public function getProposalFormContent(): Form
    {
        $form = new Form(new LoyaltyUserProposal());

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
            $tools->disableDelete();
            $tools->disableList();
        });
        $form->disableEditingCheck();
        $form->disableViewCheck();

        $form->display('id', 'ID');

        $form->select('proposal_status', 'Статус')->options(LoyaltyUserProposalStatuses::getToHumanResource());

        $form->number('accrue_points', 'Начислить баллы');

        $reasons = LoyaltyProposalCancelReason::query()->get()->mapWithKeys(static function ($item) {
            return [$item['id'] => $item['value']];
        })->toArray();
        $reasons[0] = '-';
        $form->select('loyalty_proposal_cancel_reason_id', 'Причина отказа')->options($reasons);

        $form->display('created_at', 'Дата создания');

        return $form;
    }

    /**
     * @inheritDoc
     */
    public function getFormContent(): Form
    {
        // TODO: Implement getFormContent() method.
    }

    /**
     * @return void
     */

    public function accrueLoyaltyPoints(int $userProposalId, int $value)
    {
        $proposal = $this->proposalRepository->getProposalById($userProposalId);
        if (is_null($proposal)){
            abort(404);
        }
        $proposal->accrue_points = $value;
        $proposal->save();
    }
}
