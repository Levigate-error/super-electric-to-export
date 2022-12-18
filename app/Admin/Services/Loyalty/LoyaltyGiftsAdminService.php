<?php

namespace App\Admin\Services\Loyalty;

use App\Domain\Dictionaries\Loyalty\LoyaltyGifts;
use App\Domain\Dictionaries\Loyalty\LoyaltyGiftStatuses;
use Encore\Admin\Form;
use Encore\Admin\Form\Tools;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Displayers\Actions;
use Encore\Admin\Show;
use App\Models\Loyalty\LoyaltyGift;
use App\Admin\Services\BaseService;

/**
 * Class LoyaltyGiftsAdminService
 * @package App\Admin\Services
 */
class LoyaltyGiftsAdminService extends BaseService
{
    public function getCrudPageContent(): Grid
    {
        $grid = new Grid(new LoyaltyGift());

        $grid->disableRowSelector();
        $grid->disableCreateButton();
        $grid->disableExport();

        $grid->actions(function (Actions $actions) {
            $actions->disableDelete();
            $actions->disableView();
        });

        $grid->model()->orderBy('id', 'desc');

        $grid->id('ID')->sortable();

        $grid->column('user.first_name', 'Имя')->filter();
        $grid->column('user.last_name', 'Фамилия')->filter();
        $grid->column('user.email', 'Email')->filter();
        $grid->column('user.phone', 'Телефон')->filter();
        $grid->column('created_at', 'Дата отправки')->date('Y-m-d H:i');

        $grid->column('gift.title', 'Подарок')->filter();

//        $grid->column('gift_id', 'Подарок')->display(function () {
//            return LoyaltyGifts::getToHumanResource()[$this->gift_id];
//        });
        $grid->column('status_id', 'Статус')->display(function () {
            return LoyaltyGiftStatuses::getToHumanResource()[$this->status_id];
        });

        return $grid;
    }

    /**
     * @return Form
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getFormContent(): Form
    {
        $form = new Form(new LoyaltyGift());

        $form->column(1/2, function ($form) {
            $form->display('id', 'ID');
            $form->display('user.first_name', 'Имя');
            $form->display('user.last_name', 'Фамилия');
            $form->display('user.email', 'Email');
            $form->display('user.phone', 'Телефон');
            $form->display('created_at', 'Дата создания');
            $form->display('updated_at', 'Дата обновления');
        })->setWidth(5, 3);

        $form->column(1/2, function ($form) {
            $form->display('gift.title', 'Подарки');
            //$form->select('gift_id', 'Подарки')->options(LoyaltyGifts::getToHumanResource());
            $form->select('status_id', 'Статус рассмотрения')->options(LoyaltyGiftStatuses::getToHumanResource());
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
