<?php

namespace App\Admin\Services\Loyalty;

use App\Models\Loyalty\LoyaltyDocument;
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
class LoyaltyDocumentsAdminService extends BaseService
{
    public function getCrudPageContent(): Grid
    {
        $grid = new Grid(new LoyaltyDocument());

        $grid->disableRowSelector();
        $grid->disableExport();

        $grid->actions(function (Actions $actions) {
            $actions->disableDelete();
            $actions->disableView();
        });

        $grid->model()->orderBy('id', 'ASC');

        $grid->id('ID')->sortable();

        $grid->file('file');

        return $grid;
    }

    /**
     * @return Form
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getFormContent(): Form
    {
        $form = new Form(new LoyaltyDocument());

        $form->display('id', 'ID');
        $form->file('file', 'Файл');

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
