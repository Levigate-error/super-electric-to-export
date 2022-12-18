<?php

namespace App\Admin\Services;

use Encore\Admin\Form;
use Encore\Admin\Form\NestedForm;
use Encore\Admin\Grid;
use App\Domain\ServiceContracts\BannerServiceContract;
use App\Models\Banner;
use Encore\Admin\Show;
use App\Domain\Mappers\Images\ImageSizes;

/**
 * Class BannerService
 * @package App\Admin\Services
 */
class BannerService extends BaseService
{
    /**
     * @var BannerServiceContract
     */
    private $service;

    /**
     * BannerService constructor.
     * @param BannerServiceContract $service
     */
    public function __construct(BannerServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @return Grid
     */
    public function getCrudPageContent(): Grid
    {
        $grid = new Grid(new Banner());

        $grid->disableFilter();
        $grid->disableRowSelector();
        $grid->disableExport();

        $grid->model()->orderBy('id', 'desc');

        $grid->id('ID')->sortable();
        $grid->title('Название');
        $grid->url('Ссылка');

        $grid->for_registered('Для авторизированных')->display(function () {
            return ($this->for_registered === true) ? 'Да' : 'Нет';
        });

        $grid->published('Опубликован')->display(function () {
            return ($this->published === true) ? 'Да' : 'Нет';
        });

        return $grid;
    }

    /**
     * @return Form
     */
    public function getFormContent(): Form
    {
        $form = new Form(new Banner());

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
        });

        $form->disableEditingCheck();
        $form->disableViewCheck();

        $form->tab('Основное', function (Form $form) {
            $form->display('id', 'ID');

            $form->text('title', 'Название')->rules('required|string|min:3');
            $form->text('url', 'Ссылка')->rules('required|string|min:3');

            $form->switch('for_registered', 'Для авторизированных')
                ->states($this->getOptionsForSwitch())
                ->default(true);

            $form->switch('published', 'Опубликовано')
                ->states($this->getOptionsForSwitch())
                ->default(true);

            $form->display('created_at', 'Дата создания');
            $form->display('updated_at', 'Дата обновления');
        });

        $form->tab('Изображения', static function (Form $form) {
            $form->hasMany('images', '', static function (NestedForm $nestedForm) {
                $nestedForm->select('size', 'Размер')->rules('required|string|min:3')->options(ImageSizes::getMap());
                $nestedForm->image('path', 'Изображение')->rules('image')->move('banners')->uniqueName();
            });
        });

        return $form;
    }

    /**
     * @param int $id
     * @return Show
     */
    public function getDetailPageContent($id): Show
    {
        $show = new Show(Banner::findOrFail($id));

        $show->id('Id');
        $show->title('Заголовок');
        $show->url('Заголовок');

        $show->for_registered('Для авторизированных')->as(function () {
            return ($this->for_registered === true) ? 'Да' : 'Нет';
        });

        $show->published('Опубликовано')->as(function () {
            return ($this->published === true) ? 'Да' : 'Нет';
        });

        $show->created_at('Дата создания');
        $show->updated_at('Дата обновления');

        return $show;
    }
}
