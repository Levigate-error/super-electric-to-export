<?php

namespace App\Admin\Services;

use App\Domain\Dictionaries\Feedback\FeedbackStatuses;
use App\Domain\Dictionaries\Feedback\FeedbackTypes;
use Encore\Admin\Form;
use Encore\Admin\Form\Tools;
use Encore\Admin\Form\Footer;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Displayers\Actions;
use Encore\Admin\Show;
use App\Models\Feedback;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Grid\Filter;
use App\Domain\Repositories\FeedbackRepositoryContract;
use Illuminate\Support\Facades\Storage;

/**
 * Class FeedbackService
 * @package App\Admin\Services
 */
class FeedbackService extends BaseService
{
    /**
     * @return Tab
     */
    public function getTabsContent(): Tab
    {
        $type = request()->get('type', FeedbackTypes::COMMON);

        $tab = new Tab();

        foreach (FeedbackTypes::getToHumanResource() as $typeKey => $typeName) {
            $active = $typeKey === $type;

            $tab->addLink(ucfirst($typeName), route('admin.feedback.index') . "?type=$typeKey", $active);
        }

        return $tab;
    }

    /**
     * @return Grid
     */
    public function getCrudPageContent(): Grid
    {
        $type = request()->get('type', FeedbackTypes::COMMON);

        return $this->getFeedbackGridByType($type);
    }

    /**
     * @param  string  $type
     * @return Grid
     */
    protected function getFeedbackGridByType(string $type): Grid
    {
        $grid = new Grid(new Feedback());

        $grid->disableRowSelector();
        $grid->disableCreateButton();
        $grid->disableExport();

        $grid->actions(function (Actions $actions) {
            $actions->disableDelete();
            $actions->disableView();
        });

        $grid->model()
            ->where([
                'type' => $type,
            ])
            ->orderBy('id', 'desc');

        $grid->id('ID')->sortable();
        $grid->column('name', 'Имя');
        $grid->column('email', 'E-mail');

        $grid->column('auth', 'Авторизован')->display(function () {
            return ($this->user_id === null) ? 'Нет' : 'Да';
        });

        $grid->column('text', 'Текст')->limit(80);

        $grid->column('file', 'Файл')->display(function () {
            return ($this->file === null) ? 'Нет' : 'Да';
        });

        $grid->column('status', 'Статус')->select(FeedbackStatuses::getToHumanResource());

        $grid->column('created_at', 'Дата')->date('Y-m-d H:i');

        $grid->filter(static function (Filter $filter) use ($type) {
            $filter->disableIdFilter();

            /**
             * @var $feedbackRepository FeedbackRepositoryContract
             */
            $feedbackRepository = app(FeedbackRepositoryContract::class);

            $feedbackByStatus = $feedbackRepository
                ->getByType($type)
                ->untype()
                ->groupBy('status');

            $statusSelect = [];
            foreach (FeedbackStatuses::getToHumanResource() as $statusKey => $statusName) {
                $feedbackByCurrentStatus = $feedbackByStatus->get($statusKey);
                $feedbackWithStatusCount = ($feedbackByCurrentStatus === null) ? 0 : $feedbackByCurrentStatus->count();

                $statusSelect[$statusKey] = "$statusName ($feedbackWithStatusCount)";
            }

            $filter->equal('status', 'Статус')->select($statusSelect);
        });

        return $grid;
    }

    /**
     * @return Form
     */
    public function getFormContent(): Form
    {
        $form = new Form(new Feedback());
        $form->setTitle('Обратная связь');

        $form->tools(function (Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });

        $form->footer(function (Footer $footer) {
            $footer->disableReset();
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });

        $form->display('id', 'ID');

        $form->display('email', 'E-mail');
        $form->display('name', 'Имя');
        $form->display('text', 'Текст');

        $form->select('status', 'Статус')
            ->options(FeedbackStatuses::getToHumanResource());

        $form->display('type', 'Тип')->customFormat(static function ($type) {
            return FeedbackTypes::toHuman($type);
        });

        $form->display('file', 'Файл')->customFormat(static function ($filePath) {
            if ($filePath === null) {
                return '';
            }

            $url = Storage::disk('public')->url($filePath);

            return "<a href='$url' target='_blank'>$url</a>";
        });

        $form->display('created_at', 'Дата создания');
        $form->display('updated_at', 'Дата обновления');

        return $form;
    }

    /**
     * @param  int  $id
     * @return Show
     */
    public function getDetailPageContent($id): Show
    {
        $show = new Show(Feedback::query()->findOrFail($id));

        $show->panel()->tools(static function ($tools) {
            $tools->disableEdit();
            $tools->disableDelete();
        });

        $show->id('Id');
        $show->field('email', 'E-mail');
        $show->field('name', 'Имя');
        $show->field('text', 'Текст')->setEscape(false);

        $show->field('status', 'Статус')->as(function () {
            return $this->statusOnHuman;
        });

        $show->field('type', 'Тип')->as(function () {
            return $this->typeOnHuman;
        });

        $show->field('file', 'Файл')->as(function () {
            return $this->fileUrl;
        })->link();

        $show->created_at('Дата создания');
        $show->updated_at('Дата обновления');

        return $show;
    }
}
