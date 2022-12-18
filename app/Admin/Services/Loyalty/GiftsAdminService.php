<?php

namespace App\Admin\Services\Loyalty;

use App\Models\Loyalty\Gift;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Displayers\Actions;
use App\Admin\Services\BaseService;

/**
 * Class LoyaltyGiftsAdminService
 * @package App\Admin\Services
 */
class GiftsAdminService extends BaseService
{
    public function getCrudPageContent(): Grid
    {
    	$statuses = ['Нет', 'Да'];

        $grid = new Grid(new Gift());

        $grid->disableFilter();
        $grid->disableRowSelector();
        $grid->disableExport();
        $grid->actions(function (Actions $actions) {
            $actions->disableView();
            $actions->disableDelete();
        });

        $grid->model()->orderBy('id', 'asc');

        $grid->id('ID')->sortable();
        $grid->title('Имя');
        $grid->point('Балл');
        $grid->count('Считать');

        $grid->column('completed', 'Закончено')->display(function () use ($statuses) {
            return $statuses[$this->completed];
        });

        $grid->column('is_active', 'Активный')->display(function () use ($statuses) {
            return $statuses[$this->is_active];
        });

        return $grid;
    }

    /**
     * @return Form
     */
    public function getFormContent(): Form
    {
        $form = new Form(new Gift());

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
            $tools->disableDelete();
        });

        $form->disableEditingCheck();
        $form->disableViewCheck();

        $form->display('id', 'ID');
        $form->text('title', 'Имя');
        $form->text('description', 'Описание');
        $form->text('count', 'Считать');
        $form->text('point', 'Балл');
        $form->file('image', 'Изображение');
        $form->select('completed', 'Закончено')->options([1 => 'Да', 0 => 'Нет']);
        $form->select('is_active', 'Активный')->options([1 => 'Да', 0 => 'Нет']);

        $form->display('created_at', 'Дата создания');
        $form->display('updated_at', 'Дата обновления');

        return $form;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function checkEditPossibility(int $id): bool
    {
        $productCode = $this->service->getRepository()->getById($id);

        return $productCode->active !== false;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function checkDeletePossibility(int $id): bool
    {
        return $this->checkEditPossibility($id);
    }

    /**
     * @inheritDoc
     */
    public function getDetailPageContent(int $id)
    {
        // TODO: Implement getDetailPageContent() method.
    }
}
