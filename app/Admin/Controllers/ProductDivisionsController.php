<?php

namespace App\Admin\Controllers;

use App\Domain\Dictionaries\Cache\ProductDivisionCache;
use App\Models\ProductDivision;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\MessageBag;
use App\Domain\ServiceContracts\ProductDivisionServiceContract;
use App\Domain\ServiceContracts\ProductFeatureTypeDivisionServiceContract;

/**
 * Class ProductDivisionsController
 * @package App\Admin\Controllers
 */
class ProductDivisionsController extends Controller
{
    use HasResourceActions;

    protected const PAGE_HEADER = 'Признаки изделий';

    /**
     * @var ProductDivisionServiceContract
     */
    private $service;

    /**
     * @var ProductFeatureTypeDivisionServiceContract
     */
    private $productFeatureTypeDivisionService;

    /**
     * ProductDivisionsController constructor.
     *
     * @param ProductDivisionServiceContract            $service
     * @param ProductFeatureTypeDivisionServiceContract $productFeatureTypeDivisionServiceContract
     */
    public function __construct(ProductDivisionServiceContract $service,
                                ProductFeatureTypeDivisionServiceContract $productFeatureTypeDivisionServiceContract)
    {
        $this->service = $service;
        $this->productFeatureTypeDivisionService = $productFeatureTypeDivisionServiceContract;
    }

    /**
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header(static::PAGE_HEADER)
            ->description('Список')
            ->body($this->grid());
    }

    /**
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ProductDivision());

        $grid->model()->orderBy('id', 'desc');

        $grid->actions(function ($actions) {
            $actions->disableDelete();
        });
        $grid->disableFilter();
        $grid->disableExport();
        $grid->disableRowSelector();
        $grid->disableCreateButton();
        $grid->disableColumnSelector();

        $grid->id('ID')->sortable();
        $grid->name('Название')->display(function () {
            return translate_field($this->name);
        });

        $grid->column('category', 'Товарная группа')->display(function () {
            return translate_field($this->category->name);
        });

        $grid->created_at('Дата');

        $states = [
            'on'  => ['value' => true, 'text' => 'Да', 'color' => 'primary'],
            'off' => ['value' => false, 'text' => 'Нет', 'color' => 'default'],
        ];
        $grid->published('Активно')->switch($states);

        return $grid;
    }

    /**
     * @param int     $id
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function publish(int $id, Request $request)
    {
        $status = $request->get('published') === 'on';

        if ($this->service->publish($id, $status)) {
            return response([
                'status'  => true,
                'message' => 'Запись успешно обновлена.',
            ]);
        } else {
            $error = new MessageBag([
                'title' => 'Непредвиденная ошибка.',
            ]);

            return back()->with(compact('error'));
        }
    }

    /**
     * @param         $id
     * @param Content $content
     *
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header(static::PAGE_HEADER)
            ->description('Детали')
            ->breadcrumb(
                ['text' => 'Список', 'url' => '/catalog/product-divisions'],
                ['text' => 'Детали']
            )->body($this->detail($id));
    }

    /**
     * @param $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(ProductDivision::findOrFail($id));

        $show->panel()->tools(function ($tools) {
            $tools->disableEdit();
            $tools->disableList();
            $tools->disableDelete();
        });

        $show->id('Id');

        $show->name('Название')->as(function () {
            return translate_field($this->name);
        });

        $show->column('Товарная группа')->as(function () {
            return translate_field($this->category->name);
        });

        $show->created_at('Дата создания');
        $show->updated_at('Дата обновления');

        $show->typesDivisions('Свойства товаров', function ($feature) {
            $feature->disableActions();
            $feature->disableFilter();
            $feature->disableExport();
            $feature->disableRowSelector();
            $feature->disableCreateButton();
            $feature->disableColumnSelector();

            $feature->model()->orderBy('id', 'desc');
            $feature->id('ID')->sortable();

            $feature->column('feature_type', 'Свойство')->display(function () {
                return translate_field($this->type->name);
            });

            $feature->created_at('Дата');

            $states = [
                'on'  => ['value' => true, 'text' => 'Да', 'color' => 'primary'],
                'off' => ['value' => false, 'text' => 'Нет', 'color' => 'default'],
            ];
            $feature->published('Активно')->switch($states);
        });

        return $show;
    }

    /**
     * @param int     $id
     * @param int     $featureTypeDivisionId
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function publishFeatureTypeDivision(int $id, int $featureTypeDivisionId, Request $request)
    {
        $status = $request->get('published') === 'on';

        if ($this->productFeatureTypeDivisionService->publish($featureTypeDivisionId, $status)) {
            return response([
                'status'  => true,
                'message' => 'Запись успешно обновлена.',
            ]);
        } else {
            $error = new MessageBag([
                'title' => 'Непредвиденная ошибка.',
            ]);

            return back()->with(compact('error'));
        }
    }

    /**
     * @param int $id
     * @param Content $content
     * @return Content
     */
    public function edit(int $id, Content $content): Content
    {
        $form = $this->form()->edit($id)->setAction('update');

        return $content
            ->header(static::PAGE_HEADER)
            ->body($form);
    }

    /**
     * @return Form
     */
    protected function form(): Form
    {
        $form = new Form(new ProductDivision());

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
            $tools->disableDelete();
        });

        $form->disableEditingCheck();
        $form->disableViewCheck();
        $form->disableCreatingCheck();

        $form->display('id', 'ID');

        $form->text('name', 'Название')->rules('required|string|min:3')->customFormat(static function ($value) {
            return translate_field($value);
        });

        $form->image('image', 'Изображение')->rules('image')->move('product-divisions')->uniqueName();

        $form->display('created_at', 'Дата создания');
        $form->display('updated_at', 'Дата обновления');

        $form->saving(static function (Form $form) {
            $form->name = setup_field_translate($form->name);
        });

        $form->saved(static function (Form $form) {
            Cache::tags(ProductDivisionCache::LIST)->flush();
        });

        return $form;
    }
}
