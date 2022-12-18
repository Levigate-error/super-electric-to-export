<?php

namespace App\Admin\Services;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Faq;

/**
 * Class FaqService
 * @package App\Admin\Services
 */
class FaqService extends BaseService
{
    /**
     * @return Grid
     */
    public function getCrudPageContent(): Grid
    {
        $grid = new Grid(new Faq);

        $grid->disableFilter();
        $grid->disableRowSelector();
        $grid->disableExport();

        $grid->model()->orderBy('id', 'desc');

        $grid->id('ID')->sortable();
        $grid->column('question', 'Вопрос');

        $states = $this->getOptionsForSwitch();
        $grid->published('Опубликован')->switch($states);

        return $grid;
    }

    /**
     * @return Form
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getFormContent(): Form
    {
        $form = new Form(new Faq());

        $form->display('id', 'ID');

        $form->ckeditor('question', 'Вопрос')
            ->rules('required|string|min:3');

        $form->ckeditor('answer', 'Ответ')
            ->rules('required|string|min:3');

        $form->switch('published', 'Опубликован')
            ->states($this->getOptionsForSwitch())
            ->default(true);

        $form->display('created_at', 'Дата создания');
        $form->display('updated_at', 'Дата обновления');

        return $form;
    }

    /**
     * @param int $id
     * @return Show
     */
    public function getDetailPageContent($id): Show
    {
        $show = new Show(Faq::findOrFail($id));

        $show->id('Id');
        $show->field('question', 'Вопрос')->setEscape(false);
        $show->field('answer', 'Ответ')->setEscape(false);

        $show->published('Опубликован')->as(function () {
            return ($this->published === true) ? 'Да' : 'Нет';
        });

        $show->created_at('Дата создания');
        $show->updated_at('Дата обновления');

        return $show;
    }
}
