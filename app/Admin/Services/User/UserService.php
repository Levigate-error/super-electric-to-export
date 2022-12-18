<?php

namespace App\Admin\Services\User;

use App\Admin\Extensions\Tools\ImportUserButton;
use App\Admin\Extensions\UsersExporter;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Displayers\Actions;
use App\Admin\Services\BaseService;
use App\Domain\ServiceContracts\User\UserServiceContract;
use App\Models\User;
use Encore\Admin\Grid\Filter;
use Encore\Admin\Widgets\Form as WidgetForm;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class UserService
 * @package App\Admin\Services\User
 */
class UserService extends BaseService
{
    /**
     * @var UserServiceContract
     */
    private $service;

    /**
     * UserService constructor.
     * @param UserServiceContract $service
     */
    public function __construct(UserServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @return Grid
     */
    public function getCrudPageContent(): Grid
    {
        $grid = new Grid(new User());

        $grid->tools(static function (Grid\Tools $tools) {
            $tools->append(new ImportUserButton());
        });

        $grid->disableRowSelector();
        $grid->disableCreateButton();

        $grid->actions(function (Actions $actions) {
            $actions->disableEdit();
            $actions->disableView();
        });

        $grid->model()->orderBy('id', 'desc');

        $grid->column('id', 'ID')->sortable();
        $grid->column('first_name', 'Имя');
        $grid->column('last_name', 'Фамилия');
        $grid->column('phone', 'Телефон');
        $grid->column('email', 'Email');
        $grid->column('personal_site', 'Сайт / Страница в соц. сетях');
        $grid->column('email_subscription', 'Согласен получать рассылки на эл.почту')->display(function () {
            return ($this->email_subscription === false) ? 'Нет' : 'Да';
        });
        $grid->column('source', 'Источник');
        $grid->column('city_id', 'Город')->display(function () {
            if ($this->city_id === null) {
                return '-';
            }

            return translate_field($this->city->title);
        });
        $grid->column('published', 'Опубликован')->display(function () {
            return ($this->published === true) ? 'Опубликован' : 'Не опубликован';
        });

        $grid->column('created_at', 'Дата регистрация')->date('Y-m-d H:i:s');

        $states = $this->getOptionsForSwitch();
        $grid->column('publish_ban', 'Запретить публикацию')->switch($states);

        $grid->filter(function (Filter $filter) {
            $filter->disableIdFilter();

            $filter->like('first_name', 'Имя');
            $filter->like('last_name', 'Фамилия');
            $filter->like('phone', 'Телефон');
            $filter->like('email', 'Email');

            $filter->where(function (Builder $query) {
                $query->whereHas('city', function (Builder $query) {
                    $locale = get_current_local();

                    $query->where("title->$locale", 'ILIKE', "%{$this->input}%");
                });
            }, 'Город');

            $filter->equal('published', 'Опубликован')
                ->select([
                    '0' => 'Не опубликован',
                    '1' => 'Опубликован',
                ]);
        });

        $grid->exporter(new UsersExporter());

        return $grid;
    }

    /**
     * @return Form
     */
    public function getFormContent(): Form
    {
        $form = new Form(new User());

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
        });

        $form->disableEditingCheck();
        $form->disableViewCheck();

        $form->display('id', 'ID');

        $form->hidden('published');

        $form->switch('publish_ban', 'Запретить публикацию')
            ->states($this->getOptionsForSwitch())
            ->default(false);

        $form->display('created_at', 'Дата создания');
        $form->display('updated_at', 'Дата обновления');

        $form->saving(static function (Form $form) {
            if ($form->publish_ban === 'on') {
                $form->published = false;
            }
        });

        return $form;
    }

    /**
     * @inheritDoc
     */
    public function getDetailPageContent(int $id)
    {
        // TODO: Implement getDetailPageContent() method.
    }

    /**
     * @return WidgetForm
     */
    public function getImportFormContent(): WidgetForm
    {
        $form = new WidgetForm();
        $form->title = 'Форма импорта пользователей';
        $form->method('POST');
        //$form->disablePjax();
        $form->action(route('admin.users.import'));
        $form->file('file', 'Файл')->rules('required|file|mimes:xlsx,xls,csv,txt');

        return $form;
    }
}
