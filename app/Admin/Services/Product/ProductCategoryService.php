<?php

namespace App\Admin\Services\Product;

use App\Admin\Services\BaseService;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use App\Domain\ServiceContracts\ProductCategoryServiceContract;
use App\Models\ProductCategory;
use Encore\Admin\Show;

/**
 * Class ProductCategoryService
 * @package App\Admin\Services\Product
 */
class ProductCategoryService extends BaseService
{
    /**
     * @var ProductCategoryServiceContract
     */
    private $service;

    /**
     * ProductCategoryService constructor.
     * @param ProductCategoryServiceContract $service
     */
    public function __construct(ProductCategoryServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @return Grid
     */
    public function getCrudPageContent(): Grid
    {
        $grid = new Grid(new ProductCategory());

        $grid->model()->orderBy('id', 'desc');

        $grid->actions(function ($actions) {
            $actions->disableDelete();
        });
        $grid->disableFilter();
        $grid->disableExport();
        $grid->disableRowSelector();
        $grid->disableCreateButton();
        $grid->disableColumnSelector();

        $grid->id('ID')->sortable();
        $grid->name('Название')->display(function () {
            return translate_field($this->name);
        });

        $grid->created_at('Дата');

        $states = $this->getOptionsForSwitch();
        $grid->published('Активно')->switch($states);

        return $grid;
    }

    /**
     * @return Form
     */
    public function getFormContent(): Form
    {
        $form = new Form(new ProductCategory());

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
            $tools->disableDelete();
        });

        $form->disableEditingCheck();
        $form->disableViewCheck();
        $form->disableCreatingCheck();

        $form->display('id', 'ID');

        $form->text('name', 'Название')
            ->rules('required|string|min:3')
            ->customFormat(static function ($value) {
                return translate_field($value);
        });

        $form->image('image', 'Изображение')
            ->widen(config('image.max_width'))
            ->rules('image')
            ->move('product-categories')
            ->uniqueName()
            ->removable();

        $form->switch('published', 'Опубликовано')
            ->states($this->getOptionsForSwitch())
            ->default(true);

        $form->display('created_at', 'Дата создания');
        $form->display('updated_at', 'Дата обновления');

        $form->saving(static function (Form $form) {
            if ($form->name !== null) {
                $form->name = setup_field_translate($form->name);
            }
        });

        return $form;
    }

    /**
     * @param int $id
     * @return Show
     */
    public function getDetailPageContent(int $id): Show
    {
        $show = new Show(ProductCategory::query()->findOrFail($id));

        $show->panel()->tools(static function ($tools) {
            $tools->disableEdit();
            $tools->disableList();
            $tools->disableDelete();
        });

        $show->id('Id');

        $show->name('Название')->as(function () {
            return translate_field($this->name);
        });

        $show->published('Опубликовано')->as(function () {
            return ($this->published === true) ? 'Да' : 'Нет';
        });

        $show->image('Изображение')->image();

        $show->created_at('Дата создания');
        $show->updated_at('Дата обновления');

        return $show;
    }
}
