<?php

namespace App\Admin\Services\Test;

use App\Domain\ServiceContracts\Test\TestServiceContract;
use Encore\Admin\Form;
use Encore\Admin\Form\Tools;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Show\Tools as ShowTools;
use App\Admin\Services\BaseService;
use App\Models\Test\TestQuestion;
use Illuminate\Http\Request;

/**
 * Class TestQuestionService
 * @package App\Admin\Services\Test
 */
class TestQuestionService extends BaseService
{
    /**
     * @return Grid
     */
    public function getCrudPageContent(): Grid
    {
        $grid = new Grid(new TestQuestion());

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
        $grid->column('test_id', 'Тест')->display(function () {
            return $this->test->title;
        });
        $grid->column('question', 'Вопрос')->limit(120);

        $states = $this->getOptionsForSwitch();

        $grid->column('published', 'Опубликован')->switch($states);
        $grid->column('created_at', 'Дата создания');
    }

    /**
     * @return Form|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getFormContent()
    {
        $form = new Form(new TestQuestion());

        $form->tools(function (Tools $tools) {
            $tools->disableList();
            $tools->disableDelete();
        });

        $form->disableCreatingCheck();
        $form->disableViewCheck();
        $form->disableEditingCheck();

        $form->display('id', 'ID');

        $testService = app()->make(TestServiceContract::class);
        $tests = $testService->getTestsForSelect();

        $testId = request('test_id');
        $form->select('test_id', 'Тест')
            ->options($tests)
            ->default($testId)
            ->rules('required|integer|exists:tests,id');

        $form->textarea('question', 'Вопрос')
            ->rules('required|string|max:500');

        $form->image('image', 'Изображение')
            ->widen(config('image.max_width'))
            ->rules('image')
            ->move('test-questions')
            ->uniqueName();

        $form->url('video', 'Видео')
            ->rules('url');

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

            $redirectUrl = route('admin.test.main.show', [
                'main' => $form->input('test_id'),
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
        $show = new Show(TestQuestion::query()->findOrFail($id));

        $show->panel()->tools(static function (ShowTools $tools) {
            $tools->disableList();
            $tools->disableDelete();
        });

        $show->field('id', 'ID');
        $show->field('test_id', 'Тест')->as(function () {
            return $this->test->title;
        });
        $show->field('question', 'Вопрос');
        $show->field('image', 'Изображение')->image();
        $show->field('video', 'Видео')->link();

        $show->field('published', 'Опубликован')->as(function () {
            return ($this->published === true) ? 'Да' : 'Нет';
        });

        $show->field('created_at', 'Дата создания');
        $show->field('updated_at', 'Дата обновления');

        $show->relation('testAnswers', 'Ответы', static function (Grid $testAnswerGrid) {
            $testAnswerGrid->setResource(admin_url('test/answer'));

            $testAnswerService = app()->make(TestAnswerService::class);
            $testAnswerService->setupGrid($testAnswerGrid);
        });

        return $show;
    }
}
