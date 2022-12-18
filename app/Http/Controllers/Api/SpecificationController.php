<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\WrongArgumentException;
use Illuminate\Auth\Access\AuthorizationException;
use App\Domain\ServiceContracts\Project\ProjectSpecificationServiceContract;
use App\Http\Requests\Project\ProjectSpecificationFileRequest;
use App\Http\Requests\Project\ProjectSpecificationSectionRequest;
use App\Http\Requests\Project\ProjectSpecificationProductRequest;
use App\Http\Requests\Project\ProjectSpecificationProductUpdateRequest;
use App\Http\Requests\Project\ProjectSpecificationSectionUpdateRequest;
use App\Http\Requests\Project\ProjectSpecificationProductReplaceRequest;
use App\Http\Requests\Project\ProjectSpecificationSectionProductRequest;

/**
 * Class SpecificationController
 * @package App\Http\Controllers\Api
 */
class SpecificationController extends BaseApiController
{
    /**
     * @apiDefine   ResponseBooleanResult
     *
     * @apiSuccess  {array}     data
     * @apiSuccess  {boolean}   data.result                Результат
     */

    /**
     * @apiDefine   ResponseProjectSpecificationSections
     *
     * @apiSuccess  {array}     sections                             Разделы
     * @apiSuccess  {integer}   sections.id                          Идентификатор
     * @apiSuccess  {string}    sections.title                       Название
     * @apiSuccess  {boolean}   sections.fake_section                Настоящий ли раздел
     * @apiSuccess  {array}     sections.products                    Товары
     * @apiSuccess  {integer}   sections.products.id                 Идентификатор
     * @apiSuccess  {integer}   sections.products.amount             Кол-ство
     * @apiSuccess  {float}     sections.products.price              Цена
     * @apiSuccess  {float}     sections.products.total_price        Цена с учетом кол-ства
     * @apiSuccess  {boolean}   sections.products.in_stock           В наличии
     * @apiSuccess  {boolean}   sections.products.active             Вкл/выкл
     * @apiSuccess  {integer}   sections.products.discount           Скидка, %
     * @apiSuccess  {object}    sections.products.product            Информация о товаре
     */

    /**
     * @var ProjectSpecificationServiceContract
     */
    private $service;

    /**
     * SpecificationController constructor.
     * @param ProjectSpecificationServiceContract $service
     */
    public function __construct(ProjectSpecificationServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @api            {post} api/specification/files/check Валидация файла спецификации
     * @apiName        SpecificationFilesCheck
     * @apiGroup       ProjectSpecification
     * @apiDescription Валидирует файл спецификации
     *
     * @apiParam  {file}   file        Файл спецификации. xlsx
     *
     * @apiUse    ResponseBooleanResult
     *
     * @apiError  {array}  error              Массив ошибок
     * @apiError  {string} error.level        Уровень ошибки
     * @apiError  {string} error.text         Текст ошибки
     * @apiError  {string} error.additional   Доп данные. Приходят когда нужно пояснить ошибку.
     *
     * @param ProjectSpecificationFileRequest $request
     * @return mixed
     * @throws AuthorizationException
     */
    public function checkFile(ProjectSpecificationFileRequest $request)
    {
        $this->authorize('file-check', $this->service->getRepository()->getSource());

        return $this->service->checkFile($request->validated()['file']);
    }

    /**
     * @api            {get} api/specification/files/example Получить ссылку на файл-пример спецификации
     * @apiName        SpecificationFilesExample
     * @apiGroup       ProjectSpecification
     * @apiDescription Отдает ссылку на файл-пример спецификации
     *
     * @apiSuccess  {array}    data
     * @apiSuccess  {string}   data.url        Ссылка на файл
     *
     * @return array
     * @throws AuthorizationException
     */
    public function getFileExample(): array
    {
        $this->authorize('file-example', $this->service->getRepository()->getSource());

        return $this->service->getFileExample();
    }

    /**
     * @api            {get} api/project/specification/{specification_id}/sections/list Список разделов в спецификации
     * @apiName        ProjectSpecificationSectionsList
     * @apiGroup       ProjectSpecification
     * @apiDescription Возвращает список разделов в спецификации
     *
     * @apiUse    ResponseProjectSpecificationSections
     *
     * @param int $specificationId
     * @return array
     * @throws AuthorizationException
     */
    public function specificationSectionsList(int $specificationId): array
    {
        $this->authorize('specification-sections-list', [$this->service->getRepository()->getSource(), $specificationId]);

        return array_merge(
            $this->service->getSectionWithNotUsedProductsBySpecification($specificationId),
            $this->service->getSpecificationSectionsList($specificationId)
        );
    }

    /**
     * @api            {post} api/project/specification/{specification_id}/sections/add Добавить раздел в спецификацию
     * @apiName        ProjectSpecificationSectionsAdd
     * @apiGroup       ProjectSpecification
     * @apiDescription Добавляет раздел в спецификацию
     *
     * @apiParam  {string}  title       Заголовок раздела
     *
     * @apiUse    ResponseProjectSpecificationSections
     *
     * @param int $specificationId
     * @param ProjectSpecificationSectionRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function specificationSectionAdd(int $specificationId, ProjectSpecificationSectionRequest $request): array
    {
        $this->authorize('specification-sections-add', [$this->service->getRepository()->getSource(), $specificationId]);

        $this->service->addSpecificationSection($specificationId, $request->validated());

        return $this->specificationSectionsList($specificationId);
    }

    /**
     * @api            {post} api/project/specification/{specification_id}/products/move Переместить товар из не распределенной в раздел
     * @apiName        ProjectSpecificationProductAdd
     * @apiGroup       ProjectSpecification
     * @apiDescription Перемещает товар из не распределенной в раздел спецификации
     *
     * @apiParam  {integer}  product      ID товара
     * @apiParam  {integer}  section      ID раздела
     * @apiParam  {integer}  amount       Кол-ство
     *
     * @apiUse    ResponseProjectSpecificationSections
     *
     * @param int $specificationId
     * @param ProjectSpecificationProductRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function productMove(int $specificationId, ProjectSpecificationProductRequest $request): array
    {
        $this->authorize('specification-products-move', [$this->service->getRepository()->getSource(), $specificationId]);

        $this->service->moveProduct($specificationId, $request->validated());

        return $this->specificationSectionsList($specificationId);
    }

    /**
     * @api            {patch} api/project/specification/{specification_id}/products/{specification_product_id}/update Обновить товар в разделе
     * @apiName        ProjectSpecificationProductUpdate
     * @apiGroup       ProjectSpecification
     * @apiDescription Обновляет товар в раздел спецификации
     *
     * @apiParam  {integer}  [discount]    Скидка, %
     * @apiParam  {boolean}  [active]      0, если надо выключить активность товара
     * @apiParam  {integer}  [amount]      Кол-ство
     *
     * @apiUse    ResponseProjectSpecificationSections
     *
     * @param int $specificationId
     * @param int $specificationProductId
     * @param ProjectSpecificationProductUpdateRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function productUpdate(int $specificationId, int $specificationProductId, ProjectSpecificationProductUpdateRequest $request): array
    {
        $this->authorize('specification-products-update', [$this->service->getRepository()->getSource(), $specificationId]);

        if (!$this->service->checkProductBelongToSpecification($specificationId, $specificationProductId)) {
            throw new WrongArgumentException(__('project.validation.product_belong_specification'));
        }
        $this->service->updateProduct($specificationId, $specificationProductId, $request->validated());

        return $this->specificationSectionsList($specificationId);
    }

    /**
     * @api            {delete} api/project/specification/{specification_id}/products/{specification_product_id}/delete Удалить товар из раздела
     * @apiName        ProjectSpecificationProductDelete
     * @apiGroup       ProjectSpecification
     * @apiDescription Удаляет товар из раздела спецификации
     *
     * @apiUse    ResponseProjectSpecificationSections
     *
     * @param int $specificationId
     * @param int $specificationProductId
     * @return array
     * @throws AuthorizationException
     */
    public function productDelete(int $specificationId, int $specificationProductId): array
    {
        $this->authorize('specification-products-delete', [$this->service->getRepository()->getSource(), $specificationId]);

        if (!$this->service->checkProductBelongToSpecification($specificationId, $specificationProductId)) {
            throw new WrongArgumentException(__('project.validation.product_belong_specification'));
        }
        $this->service->deleteProduct($specificationProductId);

        return $this->specificationSectionsList($specificationId);
    }

    /**
     * @api            {delete} api/project/specification/{specification_id}/sections/{specification_section_id}/delete Удалить раздел из спеки
     * @apiName        ProjectSpecificationSectionDelete
     * @apiGroup       ProjectSpecification
     * @apiDescription Удаляет раздел из спеки
     *
     * @apiUse    ResponseProjectSpecificationSections
     *
     * @param int $specificationId
     * @param int $specificationSectionId
     * @return array
     * @throws AuthorizationException
     */
    public function specificationSectionDelete(int $specificationId, int $specificationSectionId): array
    {
        $this->authorize('specification-sections-delete', [$this->service->getRepository()->getSource(), $specificationId]);

        if (!$this->service->checkSectionBelongToSpecification($specificationId, $specificationSectionId)) {
            throw new WrongArgumentException(__('project.validation.section_belong_specification'));
        }

        $this->service->deleteSection($specificationSectionId);

        return $this->specificationSectionsList($specificationId);
    }

    /**
     * @api            {patch} api/project/specification/{specification_id}/sections/{specification_section_id}/update Обновляет раздел спеки
     * @apiName        ProjectSpecificationSectionUpdate
     * @apiGroup       ProjectSpecification
     * @apiDescription Обновляет раздел спеки
     *
     * @apiParam  {integer}  [discount]    Скидка, %
     * @apiParam  {boolean}  [active]      0, если надо выключить активность раздела
     * @apiParam  {string}   [title]       Название
     *
     * @apiUse    ResponseProjectSpecificationSections
     *
     * @param int $specificationId
     * @param int $specificationSectionId
     * @param ProjectSpecificationSectionUpdateRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function specificationSectionUpdate(int $specificationId, int $specificationSectionId, ProjectSpecificationSectionUpdateRequest $request): array
    {
        $this->authorize('specification-sections-update', [$this->service->getRepository()->getSource(), $specificationId]);

        if (!$this->service->checkSectionBelongToSpecification($specificationId, $specificationSectionId)) {
            throw new WrongArgumentException(__('project.validation.section_belong_specification'));
        }

        $this->service->updateSection($specificationSectionId, $request->validated());

        return $this->specificationSectionsList($specificationId);
    }

    /**
     * @api            {post} api/project/specification/{specification_id}/products/replace Переместить товар в другой раздел
     * @apiName        ProjectSpecificationProductReplace
     * @apiGroup       ProjectSpecification
     * @apiDescription Перемещает товар в другой раздел
     *
     * @apiParam  {integer}  specification_product    ID товара в разделе
     * @apiParam  {integer}  amount                   Кол-ство
     * @apiParam  {integer}  section_from             ID секции источника
     * @apiParam  {integer}  section_to               ID секции приемника
     *
     * @apiUse    ResponseProjectSpecificationSections
     *
     * @param int $specificationId
     * @param ProjectSpecificationProductReplaceRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function productReplace(int $specificationId, ProjectSpecificationProductReplaceRequest $request): array
    {
        $this->authorize('specification-products-replace', [$this->service->getRepository()->getSource(), $specificationId]);

        $params = $request->validated();

        if (!$this->service->checkSectionBelongToSpecification($specificationId, $params['section_from']) ||
            !$this->service->checkSectionBelongToSpecification($specificationId, $params['section_to'])) {
            throw new WrongArgumentException(__('project.validation.section_belong_specification'));
        }

        if (!$this->service->checkProductBelongToSpecificationSection($params['section_from'], $params['specification_product'])) {
            throw new WrongArgumentException(__('project.validation.product_belong_section'));
        }

        $this->service->replaceProduct($specificationId, $params);

        return $this->specificationSectionsList($specificationId);
    }

    /**
     * @api            {post} api/project/specification/{specification_id}/sections/{specification_section_id}/add-product    Добавить товар в раздел
     * @apiName        ProjectSpecificationSectionProductAdd
     * @apiGroup       ProjectSpecification
     * @apiDescription Добавляет товар на прямую в раздел спецификации
     *
     * @apiParam  {integer}  product       ID товара
     * @apiParam  {integer}  [amount]      Кол-ство. По умолчанию 1.
     *
     * @apiUse    ResponseProjectSpecificationSections
     *
     * @param int $specificationId
     * @param int $specificationSectionId
     * @param ProjectSpecificationSectionProductRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function specificationSectionAddProduct(int $specificationId, int $specificationSectionId, ProjectSpecificationSectionProductRequest $request): array
    {
        $this->authorize('specification-sections-product-add', [$this->service->getRepository()->getSource(), $specificationId]);

        if (!$this->service->checkSectionBelongToSpecification($specificationId, $specificationSectionId)) {
            throw new WrongArgumentException(__('project.validation.section_belong_specification'));
        }

        $this->service->addProductToSpecificationSection($specificationId, $specificationSectionId, $request->validated());

        return $this->specificationSectionsList($specificationId);
    }
}
