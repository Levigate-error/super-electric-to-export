<?php

namespace App\Admin\Controllers;

use App\Models\ProductFamily;
use App\Http\Controllers\Controller;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Domain\ServiceContracts\ProductFamilyServiceContract;

class ProductFamiliesController extends Controller
{
    /**
     * @var ProductFamilyServiceContract
     */
    private $service;

    /**
     * ProductFamiliesController constructor.
     *
     * @param ProductFamilyServiceContract $service
     */
    public function __construct(ProductFamilyServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Серии')
            ->description('Список')
            ->body($this->grid());
    }

    /**
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ProductFamily());

        $grid->model()->orderBy('id', 'desc');

        $grid->disableActions();
        $grid->disableFilter();
        $grid->disableExport();
        $grid->disableRowSelector();
        $grid->disableCreateButton();
        $grid->disableColumnSelector();

        $grid->id('ID')->sortable();
        $grid->name('Название')->display(function () {
                return translate_field($this->name);
            }
        );
        $grid->code('Семейство');
        $grid->number('Номер');
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
}
