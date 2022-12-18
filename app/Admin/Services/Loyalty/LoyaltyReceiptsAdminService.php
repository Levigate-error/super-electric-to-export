<?php

namespace App\Admin\Services\Loyalty;

use App\Domain\Dictionaries\Loyalty\LoyaltyReceiptsStatuses;
use App\Domain\Dictionaries\Loyalty\LoyaltyReceiptsReviewStatuses;
use Encore\Admin\Form;
use Encore\Admin\Form\Tools;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Displayers\Actions;
use Encore\Admin\Show;
use App\Models\Loyalty\LoyaltyReceipt;
use Encore\Admin\Widgets\Tab;
use App\Admin\Services\BaseService;
use Illuminate\Support\Facades\Storage;

/**
 * Class LoyaltyReceiptsAdminService
 * @package App\Admin\Services
 */
class LoyaltyReceiptsAdminService extends BaseService
{
    /**
     * @return Tab
     */
    public function getTabsContent(): Tab
    {
        $status = request()->get('status', LoyaltyReceiptsStatuses::UNPROCESSED);

        $tab = new Tab();

        foreach (LoyaltyReceiptsStatuses::getToHumanResource() as $statusKey => $statusName) {
            $active = $statusKey == $status;

            $tab->addLink(ucfirst($statusName), route('admin.loyalty-program.receipts.index') .
                "?status=$statusKey", $active);
        }

        return $tab;
    }

    /**
     * @return Grid
     */
    public function getCrudPageContent(): Grid
    {
        $status = request()->get('status', LoyaltyReceiptsStatuses::UNPROCESSED);

        return $this->getReceiptsByStatus($status);
    }

    /**
     * @param  string  $status
     * @return Grid
     */
    protected function getReceiptsByStatus(int $status): Grid
    {
        $grid = new Grid(new LoyaltyReceipt());

        $grid->disableRowSelector();
        $grid->disableCreateButton();
        $grid->disableExport();

        $grid->actions(function (Actions $actions) {
            $actions->disableDelete();
            $actions->disableView();
        });

        $grid->model()
            ->where([
                'status_id' => $status,
            ])
            ->orderBy('id', 'desc');

        $grid->id('ID')->sortable();

//        $grid->filter(function($filter){
//            $filter->where(function ($query) {
//                $query->whereHas('user', function ($query)  {
//                    $query->where('first_name', 'like', "%{$this->input}%");
//                });
//            }, 'Имя');
//        });

        $grid->filter(function($filter){
            $filter->where(function ($query) {
                $query->whereHas('user', function ($query)  {
                    $query->where('last_name', 'like', "%{$this->input}%");
                });
            }, 'Фамилия');
        });

//        $grid->filter(function($filter){
//            $filter->where(function ($query) {
//                $query->whereHas('user', function ($query)  {
//                    $query->where('coupon_code', 'like', "%{$this->input}%");
//                });
//            }, 'Kод купона');
//        });

        $grid->column('user.first_name', 'Имя')->filter();
        $grid->column('user.last_name', 'Фамилия')->filter();
        $grid->column('user.email', 'Email')->filter();
        $grid->column('coupon_code', 'Kод купона')->filter();
        $grid->column('created_at', 'Дата отправки')->date('Y-m-d H:i');
        $grid->column('status_id', 'Статус')->display(function () {
            return LoyaltyReceiptsStatuses::getToHumanResource()[$this->status_id];
        });
        $grid->column('review_status_id', 'Статус рассмотрения')->display(function () {
            return LoyaltyReceiptsReviewStatuses::getToHumanResource()[$this->review_status_id];
        });

        return $grid;
    }

    /**
     * @return Form
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getFormContent(): Form
    {
        $form = new Form(new LoyaltyReceipt());

        $form->column(1/2, function ($form) {
            $form->display('id', 'ID');
            $form->display('user.first_name', 'Имя');
            $form->display('user.last_name', 'Фамилия');
            $form->display('user.email', 'Email');
            $form->display('points_already_accured', 'Баллов уже начислено');

            $form->tools(function (Tools $tools) {
                $tools->disableDelete();
                $tools->disableView();
            });
//
//            $form->multipleImage('images', 'Чеки')->pathColumn('path')
//                ->uniqueName()->retainable(true)->rules('string|min:3');


            $form->display('created_at', 'Дата создания');
            $form->display('updated_at', 'Дата обновления');
        })->setWidth(5, 3);

        $form->column(1/2, function ($form) {

            $form->display('coupon_code', 'Kод купона');
            $form->image('coupon', 'Чеки');
            $form->display('receipt_datetime', 'Дата и время на чеке');
            $form->display('fn', 'ФН');
            $form->display('fp', 'ФП');
            $form->display('fd', 'ФД');
            $form->display('amount', 'Сумма чека');

            $form->select('review_status_id', 'Статус рассмотрения')
                ->options(LoyaltyReceiptsReviewStatuses::getToHumanResource())

                //допускаем статус "Отказано" только при нулевом значении баллов
                ->rules(function ($form) {
                    $rules = 'required';
                    /*
                    if (
                        (!is_null($_POST['points_already_accured']) && (int) $_POST['points_already_accured'] !== 0)
                        || (!is_null($form->model()->points_already_accured) && (int) $form->model()->points_already_accured !== 0)
                    ) {
                        $rules .= '|not_in:' . LoyaltyReceiptsReviewStatuses::CANCELED;
                    }
                    */

                    return $rules;
                });

            $form->select('status_id', 'Статус')
                ->options(LoyaltyReceiptsStatuses::getToHumanResource());

            $form->text('points_already_accured', 'Начислить баллы')

                //допускаем ввод нулевого значения баллов только если статус рассмотрения - "Отказано"
                // либо если ранее уже были начислены баллы
                ->rules(function ($form) {
                    $rules = 'min:0';
                    /*
                    if (
                        (!is_null($form->model()->points_already_accured) && (int) $form->model()->points_already_accured !== 0)
                        && (is_null($_POST['points_already_accured']) || (int) $_POST['points_already_accured'] === 0)
                        && (int) $_POST['review_status_id'] <> LoyaltyReceiptsReviewStatuses::CANCELED
                    ) {
                        $rules .= '|numeric|required|not_in:0';
                    }
                    */

                    return $rules;
                });
        })->setWidth(5, 3);

        return $form;
    }

    /**
     * @param int $id
     * @return Show
     */
    public function getDetailPageContent($id)
    {
    }
}
