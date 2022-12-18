<?php

namespace App\Admin\Services\Loyalty;

use App\Models\Loyalty\LoyaltyCoupon;
use Encore\Admin\Form;
use Encore\Admin\Form\Tools;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Displayers\Actions;
use Encore\Admin\Show;
use App\Admin\Services\BaseService;
use Encore\Admin\Grid\Filter;

/**
 * Class LoyaltyGiftsAdminService
 * @package App\Admin\Services
 */
class LoyaltyCouponsAdminService extends BaseService
{
    public function getCrudPageContent(): Grid
    {
        $grid = new Grid(new LoyaltyCoupon());

        $grid->disableRowSelector();
        $grid->disableCreateButton();
        $grid->disableExport();

        $grid->actions(function (Actions $actions) {
            $actions->disableDelete();
            $actions->disableView();
            $actions->disableEdit();
        });

        $grid->model()->orderBy('id', 'ASC');

        $grid->id('ID')->sortable();

        $grid->column('code', 'Код')->filter();
        $grid->active('Активно')->display(function () {
            return ($this->used === false) ? 'Да' : 'Нет';
        });

        $grid->filter(function (Filter $filter) {

            $filter->like('code', 'Код');

            $filter->equal('used', 'Статус')
                ->select([
                    '0' => 'Активно',
                    '1' => 'Не Активно',
                ]);
        });


        return $grid;
    }

    /**
     * @return Form
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getFormContent(): Form
    {
        $form = new Form(new LoyaltyCoupon());

        $form->display('id', 'ID');
        $form->display('code', 'Код');

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
