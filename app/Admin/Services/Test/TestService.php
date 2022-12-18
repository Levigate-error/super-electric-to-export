<?php

namespace App\Admin\Services\Test;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Services\BaseService;
use App\Models\Test\Test;

/**
 * Class TestService
 * @package App\Admin\Services\Test
 */
class TestService extends BaseService
{
    /**
     * @return Grid
     */
    public function getCrudPageContent(): Grid
    {
        $grid = new Grid(new Test());

        $grid->disableFilter();
        $grid->disableRowSelector();
        $grid->disableExport();

        $grid->model()->orderBy('id', 'desc');

        $grid->column('id', 'ID')->sortable();
        $grid->column('title', 'Заголовок');
        $grid->column('description', 'Описание')->limit(120);
        $grid->column('created_at', 'Дата создания')->date('Y-m-d H:i:s');

        $states = $this->getOptionsForSwitch();
        $grid->column('published', 'Опубликован')->switch($states);

        return $grid;
    }

    /**
     * @return Form
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getFormContent(): Form
    {
        $form = new Form(new Test());

        $form->display('id', 'ID');

        $form->text('title', 'Заголовок')
            ->rules('required|string');

        $form->textarea('description', 'Описание')
            ->rules('required|string|max:500');

        $form->image('image', 'Изображение')
            ->widen(config('image.max_width'))
            ->rules('image')
            ->move('tests')
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
    public function getDetailPageContent(int $id): Show
    {
        $show = new Show(Test::query()->findOrFail($id));

        $show->field('id', 'ID');
        $show->field('title', 'Заголовок');
        $show->field('description', 'Описание')->setEscape(false);
        $show->field('image', 'Изображение')->image();

        $show->field('published', 'Опубликован')->as(function () {
            return ($this->published === true) ? 'Да' : 'Нет';
        });

        $show->field('created_at', 'Дата создания');
        $show->field('updated_at', 'Дата обновления');

        $show->relation('testResults', 'Результаты', static function (Grid $testResultsGrid) {
            $testResultsGrid->setResource(admin_url('test/result'));

            $testAnswerService = app()->make(TestResultService::class);
            $testAnswerService->setupGrid($testResultsGrid);
        });

        $show->relation('testQuestions', 'Вопросы', static function (Grid $testQuestionGrid) {
            $testQuestionGrid->setResource(admin_url('test/question'));

            $testAnswerService = app()->make(TestQuestionService::class);
            $testAnswerService->setupGrid($testQuestionGrid);
        });

        return $show;
    }
}
