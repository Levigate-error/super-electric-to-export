<?php

namespace App\Admin\Services;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\News;

/**
 * Class NewsService
 * @package App\Admin\Services
 */
class NewsService extends BaseService
{
    /**
     * @return Grid
     */
    public function getCrudPageContent(): Grid
    {
        $grid = new Grid(new News);

        $grid->disableFilter();
        $grid->disableRowSelector();
        $grid->disableExport();

        $grid->model()->orderBy('created_at', 'desc');

        $grid->id('ID')->sortable();
        $grid->column('title', 'Заголовок');
        $grid->column('short_description', 'Описание');

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
        $form = new Form(new News());

        $form->display('id', 'ID');

        $form->text('title', 'Заголовок')
            ->rules('required|string');

        $form->textarea('short_description', 'Описание')
            ->rules('string|max:500');

        $form->ckeditor('description', 'Контент')
            ->rules('required|string');

        $form->image('image', 'Изображение')
            ->widen(config('image.max_width'))
            ->rules('image')
            ->move('news')
            ->uniqueName();

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
        $show = new Show(News::findOrFail($id));

        $show->id('Id');
        $show->field('title', 'Заголовок');
        $show->field('short_description', 'Описание');
        $show->field('description', 'Контент')->setEscape(false);
        $show->field('image', 'Изображение')->image();

        $show->published('Опубликован')->as(function () {
            return ($this->published === true) ? 'Да' : 'Нет';
        });

        $show->created_at('Дата создания');
        $show->updated_at('Дата обновления');

        return $show;
    }
}
