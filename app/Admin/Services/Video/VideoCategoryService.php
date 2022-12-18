<?php

namespace App\Admin\Services\Video;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Services\BaseService;
use App\Models\Video\VideoCategory;

/**
 * Class VideoCategoryService
 * @package App\Admin\Services\Video
 */
class VideoCategoryService extends BaseService
{
    /**
     * @return Grid
     */
    public function getCrudPageContent(): Grid
    {
        $grid = new Grid(new VideoCategory());

        $grid->disableFilter();
        $grid->disableRowSelector();
        $grid->disableExport();

        $grid->model()->orderBy('id', 'desc');

        $grid->id('ID')->sortable();
        $grid->title('Название')->display(function () {
            return translate_field($this->title);
        });

        $states = $this->getOptionsForSwitch();
        $grid->published('Опубликован')->switch($states);

        return $grid;
    }

    /**
     * @return Form
     */
    public function getFormContent(): Form
    {
        $form = new Form(new VideoCategory());

        $form->display('id', 'ID');

        $form->text('title', 'Название')
            ->rules('required|string|min:3')
            ->customFormat(static function ($value) {
                return translate_field($value);
            });

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
        $show = new Show(VideoCategory::findOrFail($id));

        $show->id('Id');
        $show->title('Название')->as(function () {
            return translate_field($this->title);
        });

        $show->published('Опубликован')->as(function () {
            return ($this->published === true) ? 'Да' : 'Нет';
        });

        $show->created_at('Дата создания');
        $show->updated_at('Дата обновления');

        $states = $this->getOptionsForSwitch();

        $show->videos('Видео', static function (Grid $videoGrid) use ($states) {
            $videoGrid->disableActions();
            $videoGrid->disableFilter();
            $videoGrid->disableExport();
            $videoGrid->disableRowSelector();
            $videoGrid->disableCreateButton();
            $videoGrid->disableColumnSelector();

            $videoGrid->model()->orderBy('id', 'desc');

            $videoGrid->id('ID')->sortable();
            $videoGrid->title('Название')->display(function () {
                return translate_field($this->title);
            });
            $videoGrid->video('Видео')->link();

            $videoGrid->published('Опубликован')->display(function () {
                return ($this->published === true) ? 'Да' : 'Нет';
            });
        });

        return $show;
    }
}
