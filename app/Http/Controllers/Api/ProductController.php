<?php

namespace App\Http\Controllers\Api;

use App\Domain\ServiceContracts\ProductServiceContract;
use App\Domain\ServiceContracts\FavoriteProductServiceContract;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\FavoriteProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Models\Product;
use Maatwebsite\Excel\Excel;

class ProductController extends BaseApiController
{
    /**
     * @apiDefine   ResponseProducts
     * @apiSuccess  {integer}   product.id            Идентификатор
     * @apiSuccess  {string}    product.name          Название
     * @apiSuccess  {string}    product.vendor_code   Вендор код
     * @apiSuccess  {float}     product.recommended_retail_price    Рекомендуемая цена
     * @apiSuccess  {integer}   product.min_amount    Мин кол-ство
     * @apiSuccess  {string}    product.unit          Размерность
     * @apiSuccess  {string}    product.img           Изображение
     * @apiSuccess  {boolean}   product.is_favorites  В изранном
     * @apiSuccess  {array}     product.attributes    Доп параметры
     * @apiSuccess  {string}    product.attributes.title  Название параметра
     * @apiSuccess  {string}    product.attributes.value  Значение параметра
     */

    /**
     * @var ProductServiceContract
     */
    private $service;

    /**
     * ProductController constructor.
     *
     * @param ProductServiceContract $service
     */
    public function __construct(ProductServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @api            {post} api/catalog/products Список товаров
     * @apiName        ProductList
     * @apiGroup       Catalog
     * @apiDescription Возвращает список товаров
     *
     * @apiParam  {integer}  [category]               ID товарной группы
     * @apiParam  {integer}  [division]               ID признака изделия
     * @apiParam  {integer}  [family]                 ID серии
     * @apiParam  {integer}  [price_from]             Цена от
     * @apiParam  {integer}  [price_to]               Цена до
     * @apiParam  {integer}  [limit]                  Кол-ство записей. По умолчанию 18.
     * @apiParam  {integer}  [page]                   Страница
     * @apiParam  {array}    [filter_values]          Параметры из фильтра
     * @apiParam  {integer}  [filter_values.type_id]  ID Типа фильтра
     * @apiParam  {array}    [filter_values.values]   Массив ID значений параметров из фильтра
     * @apiParam  {string}   [search]                 Строка поиска
     * @apiParam  {boolean}  [favorite]               1, если надо вернуть только избранные товары
     * @apiParam  {string}   [sort_column]            Поле из ресурса товара, по которому будет сортировка. Например rank, recommended_retail_price
     * @apiParam  {string}   [sort_type]              asc или desc. По умолчанию desc
     * @apiParam  {boolean}  [is_loyalty]             1, если надо вернуть товары для программы лояльности
     *
     * @apiSuccess     {Array} data
     * @apiUse    ResponseProducts
     *
     * @param ProductRequest $request
     *
     * @return mixed
     */
    public function listByParams(ProductRequest $request)
    {
        return $this->service->getProductsByParams($request->validated());
    }

    /**
     * @api            {post} api/catalog/products/add-to-favorite Добавить товар в избранные
     * @apiName        AddProductToFavorite
     * @apiGroup       Catalog
     * @apiDescription Добавляет товар в избранные
     *
     * @apiParam  {integer}  product       ID товара
     *
     * @apiSuccess     {Array} data
     *
     * @param FavoriteProductRequest $request
     * @param FavoriteProductServiceContract $favoriteService
     * @return mixed
     * @throws AuthorizationException
     */
    public function addToFavorite(FavoriteProductRequest $request, FavoriteProductServiceContract $favoriteService)
    {
        $this->authorize('work-with-favorite', $this->service->getRepository()->getSource());

        return $favoriteService->addProductsToFavorite($request->validated(), Auth::user());
    }

    /**
     * @api            {post} api/catalog/products/remove-from-favorite Удалить товар из избранных
     * @apiName        RemoveProductsFromFavorite
     * @apiGroup       Catalog
     * @apiDescription Удаляет товар из избранных
     *
     * @apiParam  {integer}  product       ID товара
     *
     * @apiSuccess     {Array} data
     *
     * @param FavoriteProductRequest $request
     * @param FavoriteProductServiceContract $favoriteService
     * @return mixed
     * @throws AuthorizationException
     */
    public function removeFromFavorite(FavoriteProductRequest $request, FavoriteProductServiceContract $favoriteService)
    {
        $this->authorize('work-with-favorite', $this->service->getRepository()->getSource());

        return $favoriteService->removeProductsFromFavorite($request->validated(), Auth::user());
    }

    /**
     * @api            {get} api/catalog/products/recommended Рекомендованные товаров
     * @apiName        RecommendedProducts
     * @apiGroup       Catalog
     * @apiDescription Возвращает список рекомендованных товаров
     *
     * @apiUse    ResponseProducts
     *
     * @return array
     * @throws AuthorizationException
     */
    public function getRecommended(): array
    {
        $this->authorize('recommended', $this->service->getRepository()->getSource());

        return $this->service->getRecommendedProducts();
    }

    /**
     * @api            {get} api/catalog/products/{id}/buy-with-it С этим покупают
     * @apiName        BuyWithItProducts
     * @apiGroup       Catalog
     * @apiDescription Возвращает список товаров которые используются в тех же проектах
     *
     * @apiUse    ResponseProducts
     *
     * @param int $productId
     * @return array
     * @throws AuthorizationException
     */
    public function getBuyWithIt(int $productId): array
    {
        $this->authorize('buy-with-it', $this->service->getRepository()->getSource());

        return $this->service->getBuyWithItProducts($productId);
    }

    public function createWithExcel(Request $request)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        if($request->hasFile('file')){
            $excel = new \Maatwebsite\Excel\Excel;
            $path = $request->file('file')->getRealPath();
            $data = $excel->import($request->file('file'), $path)->toArray();

            $out->writeln($data);
            if(!empty($data) && $data->count()){
                foreach ($data->toArray() as $key => $value) {
                    if(!empty($value)){
                        foreach ($value as $v) {
                            $insert[] = ['title' => $v['title'], 'description' => $v['description']];
                        }
                    }
                }
                if(!empty($insert)){
                    Product::insert($insert);
                        return 'hmm';
                }
            }
        }
        return 'hmmm';
    }
}
