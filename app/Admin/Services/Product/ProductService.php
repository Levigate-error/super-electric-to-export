<?php

namespace App\Admin\Services\Product;

use App\Admin\Services\BaseService;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use App\Models\Product;
use App\Domain\Repositories\ProductRepository;

/**
 * Class ProductService
 * @package App\Admin\Services\Product
 */
class ProductService extends BaseService
{
    /**
     * @return Grid
     */
    public function getCrudPageContent(): Grid
    {
        $grid = new Grid(new Product());

        $grid->disableActions();
        $grid->disableFilter();
        $grid->disableExport();
        $grid->disableRowSelector();
        $grid->disableCreateButton();
        $grid->disableColumnSelector();

        $grid->model()->orderBy('id', 'desc');

        $grid->column('id', 'ID')->sortable();
        $grid->column('vendor_code', 'Артикул');
        $grid->column('name', 'Название')->display(function () {
            return translate_field($this->name);
        });
        $grid->column('rank', 'Ранг')->editable();

        $grid->column('category', 'Товарная группа')->display(function () {
            $published = ($this->category->published === true) ? 'Опубликована' : 'Не Опубликована';

            return translate_field($this->category->name) . '. ' . $published;
        });

        $grid->column('division', 'Признак изделия')->display(function () {
            $published = ($this->division->published === true) ? 'Опубликована' : 'Не Опубликована';

            return translate_field($this->division->name) . '. ' . $published;
        });

        $grid->column('family', 'Серия')->display(function () {
            $published = ($this->family->published === true) ? 'Опубликована' : 'Не Опубликована';

            return translate_field($this->family->name) . '. ' . $published;
        });

        $states = $this->getOptionsForSwitch();
        $grid->column('is_recommended', 'Рекомендован')->switch($states);
        $grid->column('is_loyalty', 'В лояльности')->switch($states);

        return $grid;
    }

    /**
     * @return Form
     */
    public function getFormContent(): Form
    {
        $form = new Form(new Product());

        $form->text('rank', 'Ранг');

        $states = $this->getOptionsForSwitch();
        $form->switch('is_recommended', 'Рекомендован')
            ->states($states)
            ->default(false);

        $form->switch('is_loyalty', 'В лояльности')
            ->states($states)
            ->default(false);

        $form->saving(static function (Form $form) {
            if ($form->model()->getAttribute('is_recommended') === false) {
                /**
                 * @var $productRepository ProductRepository
                 */
                $productRepository = app()->make(ProductRepository::class);

                $products = $productRepository->getRecommendedProducts();

                if ($products->count() >= (int) config('products.recommended_limit')) {
                    return response([
                        'message' => 'Рекомендованных товаров должно быть не больше ' . config('products.recommended_limit'),
                        'status' => false,
                    ]);
                }
            }
        });

        return $form;
    }

    public function getDetailPageContent(int $id)
    {
        // TODO: Implement getDetailPageContent() method.
    }
}
