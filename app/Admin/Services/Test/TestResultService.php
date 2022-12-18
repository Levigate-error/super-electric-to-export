<?php

namespace App\Admin\Services\Test;

use App\Domain\Repositories\Test\TestResultRepositoryContract;
use App\Domain\ServiceContracts\Test\TestServiceContract;
use Encore\Admin\Form;
use Encore\Admin\Form\Tools;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Show\Tools as ShowTools;
use App\Admin\Services\BaseService;
use App\Models\Test\TestResult;
use Illuminate\Support\MessageBag;

/**
 * Class TestResultService
 * @package App\Admin\Services\Test
 */
class TestResultService extends BaseService
{
    /**
     * @return Grid
     */
    public function getCrudPageContent(): Grid
    {
        $grid = new Grid(new TestResult());

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
        $grid->column('title', 'Заголовок');
        $grid->column('description', 'Описание')->limit(120);
        $grid->column('percent_from', 'От, %');
        $grid->column('percent_to', 'До, %');
        $grid->column('points', 'Баллы');
        $grid->column('created_at', 'Дата создания');
    }

    /**
     * @return Form|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getFormContent()
    {
        $form = new Form(new TestResult());

        $form->tools(function (Tools $tools) {
            $tools->disableList();
            $tools->disableDelete();
        });

        $form->disableCreatingCheck();
        $form->disableViewCheck();
        $form->disableEditingCheck();

        $form->display('id', 'ID');

        $form->text('title', 'Заголовок')
            ->rules('required|string');

        $testService = app()->make(TestServiceContract::class);
        $tests = $testService->getTestsForSelect();

        $testId = request('test_id');
        $form->select('test_id', 'Тест')
            ->options($tests)
            ->default($testId)
            ->rules('required|integer|exists:tests,id');

        $form->image('image', 'Изображение')
            ->widen(config('image.max_width'))
            ->rules('image')
            ->move('test_results')
            ->uniqueName();

        $form->textarea('description', 'Описание')
            ->rules('required|string|max:500');

        $form->number('percent_from', 'От, %')
            ->rules('required|integer|min:0|max:100')
            ->min(0)
            ->max(100)
            ->default(0);

        $form->number('percent_to', 'До, %')
            ->rules('required|integer|min:1|max:100|gt:percent_from', [
                'gt' => ':attribute должен быть больше, чем "От".',
            ])
            ->min(1)
            ->max(100)
            ->default(1);

        $form->number('points', 'Баллы')
            ->rules('required|integer|min:0')
            ->min(0)
            ->default(0);

        $form->display('created_at', 'Дата создания');
        $form->display('updated_at', 'Дата обновления');

        $form->saving(static function (Form $form) {
            $testResultRepository = app()->make(TestResultRepositoryContract::class);

            $intersectionResults = $testResultRepository->getIntersectionResults(
                $form->input('test_id'),
                $form->input('percent_from'),
                $form->input('percent_to'),
                $form->model()->getAttribute('id')
            );

            if ($intersectionResults->isNotEmpty() === true) {
                $message = new MessageBag([
                    'percent_from' => 'Диапазон пересекается с другими результами теста',
                    'percent_to' => 'Диапазон пересекается с другими результами теста',
                ]);

                return back()->withInput()->withErrors($message);
            }
        });

        $form->saved(static function (Form $form) {
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
        $show = new Show(TestResult::query()->findOrFail($id));

        $show->panel()->tools(static function (ShowTools $tools) {
            $tools->disableList();
            $tools->disableDelete();
        });

        $show->field('id', 'ID');
        $show->field('test_id', 'Тест')->as(function () {
            return $this->test->title;
        });
        $show->field('title', 'Заголовок');
        $show->field('image', 'Изображение')->image();
        $show->field('description', 'Описание')->setEscape(false);
        $show->field('percent_from', 'От, %');
        $show->field('percent_to', 'До, %');
        $show->field('points', 'Баллы');
        $show->field('created_at', 'Дата создания');
        $show->field('updated_at', 'Дата обновления');

        return $show;
    }
}
