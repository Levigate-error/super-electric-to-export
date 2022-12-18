<?php

namespace App\Admin\Services\Video;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Services\BaseService;
use App\Models\Video\Video;
use App\Domain\Repositories\Video\VideoCategoryRepositoryContract;

/**
 * Class VideoService
 * @package App\Admin\Services\Video
 */
class VideoService extends BaseService
{
    /**
     * @return Grid
     */
    public function getCrudPageContent(): Grid
    {
        $grid = new Grid(new Video());

        $grid->disableFilter();
        $grid->disableRowSelector();
        $grid->disableExport();

        $grid->model()->orderBy('id', 'desc');

        $grid->id('ID')->sortable();
        $grid->title('Название')->display(function () {
            return translate_field($this->title);
        });
        $grid->video('Видео')->link();

        $grid->column('videoCategory', 'Категория')->display(function () {
            return translate_field($this->videoCategory->title);
        });

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
        $form = new Form(new Video());

        $form->display('id', 'ID');

        $form->text('title', 'Название')
            ->rules('required|string|min:3')
            ->customFormat(static function ($value) {
                return translate_field($value);
            });

        $form->url('video', 'Видео')
            ->rules('required|url');

        $videoCategoryRepository = app()->make(VideoCategoryRepositoryContract::class);
        $videoCategories = $videoCategoryRepository
            ->getByParams()
            ->untype()
            ->mapWithKeys(static function ($item) {
                return [
                    $item['id'] => translate_field($item['title'])
                ];
            })
            ->toArray();

        $form->select('video_category_id', 'Категория')
            ->options($videoCategories)
            ->rules('required|integer|exists:video_categories,id');

        $form->switch('published', 'Опубликован')
            ->states($this->getOptionsForSwitch())
            ->default(true);

        $form->display('created_at', 'Дата создания');
        $form->display('updated_at', 'Дата обновления');

        $form->saving(static function (Form $form) {
            if ($form->title !== null) {
                $form->title = setup_field_translate($form->title);
            }
        });

        return $form;
    }

    /**
     * @param int $id
     * @return Show
     */
    public function getDetailPageContent($id): Show
    {
        $show = new Show(Video::findOrFail($id));

        $show->id('Id');
        $show->title('Название')->as(function () {
            return translate_field($this->title);
        });

        $show->video('Видео')->link();

        $show->column('Категория')->as(function () {
            return translate_field($this->videoCategory->title);
        });

        $show->published('Опубликован')->as(function () {
            return ($this->published === true) ? 'Да' : 'Нет';
        });

        $show->created_at('Дата создания');
        $show->updated_at('Дата обновления');

        return $show;
    }
}
