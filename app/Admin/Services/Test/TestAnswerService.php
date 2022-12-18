<?php

namespace App\Admin\Services\Test;

use App\Domain\ServiceContracts\Test\TestQuestionServiceContract;
use Encore\Admin\Form;
use Encore\Admin\Form\Tools;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Show\Tools as ShowTools;
use App\Admin\Services\BaseService;
use App\Models\Test\TestAnswer;
use Illuminate\Http\Request;

/**
 * Class TestAnswerService
 * @package App\Admin\Services\Test
 */
class TestAnswerService extends BaseService
{
    /**
     * @return Grid
     */
    public function getCrudPageContent(): Grid
    {
        $grid = new Grid(new TestAnswer());

        $this->setupGrid($grid);

        return $grid;
    }

    /**
     * @param Grid $grid
     */
    public function setupGrid(Grid $grid): void
    {
        $grid->disableFilter();
        $grid->disableRowSelector();
        $grid->disableExport();

        $grid->model()->orderBy('id', 'desc');

        $grid->column('id', 'ID')->sortable();

        $grid->column('test_question_id', 'Вопрос')->display(function () {
            return $this->testQuestion->question;
        })->limit(40);

        $states = $this->getOptionsForSwitch();

        $grid->column('answer', 'Ответ')->limit(80);
        $grid->column('is_correct', 'Правильный')->switch($states);
        $grid->column('description', 'Описание')->limit(80);
        $grid->column('points', 'Баллы');
        $grid->column('published', 'Опубликован')->switch($states);
    }

    /**
     * @return Form|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getFormContent()
    {
        $form = new Form(new TestAnswer());

        $form->tools(function (Tools $tools) {
            $tools->disableList();
            $tools->disableDelete();
        });

        $form->disableCreatingCheck();
        $form->disableViewCheck();
        $form->disableEditingCheck();

        $form->display('id', 'ID');

        $testQuestionService = app()->make(TestQuestionServiceContract::class);
        $testQuestions = $testQuestionService->getTestQuestionsForSelect();

        $testQuestionId = request('test_question_id');
        $form->select('test_question_id', 'Вопрос')
            ->options($testQuestions)
            ->default($testQuestionId)
            ->rules('required|integer|exists:test_questions,id');

        $form->text('answer', 'Ответ')
            ->rules('required|string|max:128');

        $form->textarea('description', 'Описание')
            ->rules('required|string|max:500');

        $form->number('points', 'Баллы')
            ->rules('required|integer|min:0')
            ->min(0)
            ->default(0);

        $form->switch('is_correct', 'Правильный')
            ->states($this->getOptionsForSwitch())
            ->default(false);

        $form->switch('published', 'Опубликован')
            ->states($this->getOptionsForSwitch())
            ->default(true);

        $form->display('created_at', 'Дата создания');
        $form->display('updated_at', 'Дата обновления');

        $form->saved(static function (Form $form) {
            $request = Request::capture();

            if ($request->ajax() && !$request->pjax()) {
                return response()->json([
                    'status'  => true,
                    'message' => trans('admin.update_succeeded'),
                ]);
            }

            admin_toastr(trans('admin.save_succeeded'));

            $redirectUrl = route('admin.test.question.show', [
                'question' => $form->input('test_question_id'),
            ]);

            return redirect($redirectUrl);
        });

        return $form;
    }

    /**
     * @param int $id
     * @return Show
     */
    public function getDetailPageContent(int $id): Show
    {
        $show = new Show(TestAnswer::query()->findOrFail($id));

        $show->panel()->tools(static function (ShowTools $tools) {
            $tools->disableList();
            $tools->disableDelete();
        });

        $show->field('id', 'ID');
        $show->field('test_question_id', 'Вопрос')->as(function () {
            return $this->testQuestion->question;
        });

        $show->field('answer', 'Ответ');
        $show->field('description', 'Описание');
        $show->field('points', 'Баллы');

        $show->field('is_correct', 'Правильный')->as(function () {
            return ($this->is_correct === true) ? 'Да' : 'Нет';
        });

        $show->field('published', 'Опубликован')->as(function () {
            return ($this->published === true) ? 'Да' : 'Нет';
        });

        $show->field('created_at', 'Дата создания');
        $show->field('updated_at', 'Дата обновления');

        return $show;
    }
}
