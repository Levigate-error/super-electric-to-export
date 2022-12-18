<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Project\ProjectSpecificationFileRequest;
use Illuminate\Auth\Access\AuthorizationException;
use App\Domain\ServiceContracts\Project\ProjectStatusServiceContract;
use App\Domain\ServiceContracts\Project\ProjectServiceContract;
use App\Domain\ServiceContracts\Project\ProjectProductUpdateContract;
use App\Http\Requests\Project\ProjectRequest;
use App\Http\Requests\Project\ProjectsListRequest;
use App\Http\Requests\Project\ProjectProductRequest;
use App\Http\Requests\Project\ProjectCategoryRequest;
use App\Http\Requests\Project\ProjectProductsSearchRequest;
use App\Http\Requests\Project\ProjectProductUpdateRequest;
use App\Http\Requests\Project\ProjectProductChangesRequest;
use App\Domain\UtilContracts\Files\FilesManagerContract;
use App\Exceptions\WrongArgumentException;

class ProjectController extends BaseApiController
{
    /**
     * @apiDefine   RequestUpdateProject
     *
     * @apiParam  {string}    [title]              Название
     * @apiParam  {string}    [address]            Адрес
     * @apiParam  {integer}   [project_status_id]  ID статуса
     * @apiParam  {array}     [contacts]           Контакты
     * @apiParam  {string}    [contacts.name]      Имя контакта
     * @apiParam  {string}    [contacts.phone]     Телефон контакта
     * @apiParam  {array}     [attributes]         ID значений атрибутов
     */

    /**
     * @apiDefine   RequestCreateProject
     *
     * @apiParam  {string}    [title]              Название
     * @apiParam  {string}    [address]            Адрес
     * @apiParam  {integer}   [project_status_id]  ID статуса
     */

    /**
     * @apiDefine   ResponseProject
     *
     * @apiSuccess  {integer}   id              Идентификатор
     * @apiSuccess  {string}    title           Название
     * @apiSuccess  {string}    address         Адрес
     * @apiSuccess  {float}     total_price     Стоимость проекта
     * @apiSuccess  {string}    updated_at      Дата обновления
     *
     * @apiSuccess  {object}    status          Статус
     * @apiSuccess  {integer}   status.id       Идентификатор статуса
     * @apiSuccess  {string}    status.title    Название статуса
     * @apiSuccess  {string}    status.slug     Слаг статуса
     * @apiSuccess  {string}    status.color    Цвет статуса
     *
     * @apiSuccess  {array}     contacts        Контакты
     * @apiSuccess  {integer}   contacts.id     Идентификатор контакта
     * @apiSuccess  {string}    contacts.name   Имя контакта
     * @apiSuccess  {string}    contacts.phone  Телефон контакта
     *
     * @apiSuccess  {array}     attributes                   Атрибуты
     * @apiSuccess  {integer}   attributes.id                Идентификатор связи атрибута и проекта
     * @apiSuccess  {array}     attributes.attribute         Атрибут
     * @apiSuccess  {integer}   attributes.attribute.id      Идентификатор атрибута
     * @apiSuccess  {string}    attributes.attribute.title   Название атрибута
     * @apiSuccess  {array}     attributes.value             Значение атрибута
     * @apiSuccess  {integer}   attributes.value.id          Идентификатор значения
     * @apiSuccess  {string}    attributes.value.title       Название значения
     */

    /**
     * @apiDefine   ResponseStatus
     *
     * @apiSuccess  {array}     data          Статусы
     * @apiSuccess  {integer}   data.id       Идентификатор
     * @apiSuccess  {string}    data.title    Название
     * @apiSuccess  {string}    data.slug     Слаг
     * @apiSuccess  {string}    data.color    Цвет
     */

    /**
     * @apiDefine   ResponseCategory
     *
     * @apiSuccess  {array}     data       Категории
     * @apiSuccess  {integer}   data.id    Идентификатор
     * @apiSuccess  {string}    data.name  Название
     */

    /**
     * @apiDefine   ResponseProjectCategoryDivisions
     *
     * @apiSuccess  {array}     data                 Признаки изделий
     * @apiSuccess  {integer}   data.id              Идентификатор
     * @apiSuccess  {string}    data.name            Название
     * @apiSuccess  {integer}   data.product_amount  Кол-ство товаров
     */

    /**
     * @apiDefine   ResponseProjectProducts
     *
     * @apiSuccess  {array}     product                             Товары
     * @apiSuccess  {integer}   product.id                          Идентификатор
     * @apiSuccess  {string}    product.name                        Название
     * @apiSuccess  {string}    product.vendor_code                 Вендор код
     * @apiSuccess  {float}     product.recommended_retail_price    Рекомендуемая цена
     * @apiSuccess  {integer}   product.min_amount                  Мин кол-ство
     * @apiSuccess  {string}    product.unit                        Размерность
     * @apiSuccess  {string}    product.img                         Изображение
     * @apiSuccess  {boolean}   product.is_favorites                В изранном
     * @apiSuccess  {array}     product.attributes                  Доп параметры
     * @apiSuccess  {string}    product.values.title                Название параметра
     * @apiSuccess  {string}    product.values.value                Значение параметра
     * @apiSuccess  {integer}   product.amount                      Кол-ство
     */

    /**
     * @apiDefine   ResponseCompareProducts
     *
     * @apiSuccess  {array}     changes
     * @apiSuccess  {integer}   changes.id                      Идентификатор
     * @apiSuccess  {string}    changes.vendor_code             Артикул
     * @apiSuccess  {string}    changes.name                    Название
     * @apiSuccess  {string}    changes.old_value               Старое значение
     * @apiSuccess  {string}    changes.new_value               Новое значение
     * @apiSuccess  {string}    changes.type                    Тип изменения
     * @apiSuccess  {string}    changes.typeOnHuman             Тип изменения на человеческом
     * @apiSuccess  {boolean}   changes.used                    Применялось ли
     */

    /**
     * @apiDefine   ResponseBooleanResult
     *
     * @apiSuccess  {array}     data
     * @apiSuccess  {boolean}   data.result                Результат
     */

    /**
     * @var ProjectServiceContract
     */
    private $service;

    /**
     * @var ProjectStatusServiceContract
     */
    private $statusService;

    /**
     * @var FilesManagerContract
     */
    private $filesManager;

    /**
     * ProjectController constructor.
     * @param ProjectServiceContract $service
     * @param ProjectStatusServiceContract $statusService
     * @param FilesManagerContract $filesManager
     */
    public function __construct(
        ProjectServiceContract $service,
        ProjectStatusServiceContract $statusService,
        FilesManagerContract $filesManager
    )
    {
        $this->service = $service;
        $this->statusService = $statusService;
        $this->filesManager = $filesManager;
    }

    /**
     * @api            {post} api/project/create Создать проект
     * @apiName        ProjectCreate
     * @apiGroup       Project
     * @apiDescription Создает новый проект
     *
     * @apiUse    RequestCreateProject
     * @apiUse    ResponseProject
     *
     * @param ProjectRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function store(ProjectRequest $request): array
    {
        $this->authorize('create', $this->service->getRepository()->getSource());

        return $this->service->store($request->validated());
    }

    /**
     * @api            {post} api/project/update/{id} Обновить проект
     * @apiName        ProjectUpdate
     * @apiGroup       Project
     * @apiDescription Обновляет проект
     *
     * @apiUse    RequestUpdateProject
     * @apiUse    ResponseProject
     *
     * @param int $projectId
     * @param ProjectRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function update(int $projectId, ProjectRequest $request): array
    {
        $this->authorize('update', [$this->service->getRepository()->getSource(), $projectId]);

        return $this->service->update($projectId, $request->validated());
    }

    /**
     * @api            {delete} api/project/delete/{id} Удалить проект
     * @apiName        ProjectDelete
     * @apiGroup       Project
     * @apiDescription Удаляет проект
     *
     * @apiUse    ResponseBooleanResult
     *
     * @param int $projectId
     * @return array
     * @throws AuthorizationException
     */
    public function delete(int $projectId): array
    {
        $this->authorize('delete', [$this->service->getRepository()->getSource(), $projectId]);

        return [
            'result' => $this->service->delete($projectId),
        ];
    }

    /**
     * @api            {get} api/project/list Список проектов
     * @apiName        ProjectList
     * @apiGroup       Project
     * @apiDescription Возвращает список проектов
     *
     * @apiParam  {integer}  [project_status_id]    Статус
     * @apiParam  {integer}  [limit]                Кол-ство записей. По умолчанию 15.
     * @apiParam  {integer}  [page]                 Страница
     *
     * @apiUse    ResponseProject
     *
     * @param ProjectsListRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function list(ProjectsListRequest $request): array
    {
        $this->authorize('list', $this->service->getRepository()->getSource());

        return $this->service->getUserProjectsList($request->validated());
    }

    /**
     * @api            {post} api/project/product/add Добавить товар в проект(ы)
     * @apiName        AddProduct
     * @apiGroup       Project
     * @apiDescription Добавляет товар в проект(ы)
     *
     * @apiParam  {integer}  product             ID товара
     * @apiParam  {array}    projects            Массив проектов
     * @apiParam  {integer}  [projects.amount]   Кол-ство товаров в проект. Если нет, то 1
     * @apiParam  {integer}  projects.project    ID проекта
     *
     * @apiUse    ResponseBooleanResult
     *
     * @param ProjectProductRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function addProduct(ProjectProductRequest $request): array
    {
        $this->authorize('add-product', $this->service->getRepository()->getSource());

        return [
            'result' => $this->service->addProductToProjects($request->validated()),
        ];
    }

    /**
     * @api            {get} api/project/status/list Список статусов у проекта
     * @apiName        StatusesList
     * @apiGroup       Project
     * @apiDescription Возвращает список статусов
     *
     * @apiUse    ResponseStatus
     *
     * @return array
     */
    public function statusesList(): array
    {
        return $this->statusService->getStatusesList();
    }

    /**
     * @api            {post} api/project/category/add/{id} Добавить категорию в проект
     * @apiName        AddCategory
     * @apiGroup       Project
     * @apiDescription Добавляет категорию в проект
     *
     * @apiParam  {integer}  product_category   ID категории
     *
     * @apiUse    ResponseCategory
     *
     * @param int $projectId
     * @param ProjectCategoryRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function addCategory(int $projectId, ProjectCategoryRequest $request): array
    {
        $this->authorize('add-category', [$this->service->getRepository()->getSource(), $projectId]);

        $this->service->addCategoryToProject($projectId, $request->validated());

        return $this->categoriesList($projectId);
    }

    /**
     * @api            {delete} api/project/{id}/category/{category_id} Удалить категорию из проекта
     * @apiName        DeleteCategory
     * @apiGroup       Project
     * @apiDescription Удаляет категорию из проекта
     *
     * @apiUse    ResponseCategory
     *
     * @param int $projectId
     * @param int $categoryId
     * @return array
     * @throws AuthorizationException
     */
    public function deleteCategory(int $projectId, int $categoryId): array
    {
        $this->authorize('delete-category', [$this->service->getRepository()->getSource(), $projectId]);

        $this->service->deleteCategoryFromProject($projectId, $categoryId);

        return $this->categoriesList($projectId);
    }

    /**
     * @api            {get} api/project/category/list/{id} Список категорий у проекта
     * @apiName        CategoriesList
     * @apiGroup       Project
     * @apiDescription Возвращает список категорий
     *
     * @apiUse    ResponseCategory
     *
     * @param int $projectId
     * @return array
     * @throws AuthorizationException
     */
    public function categoriesList(int $projectId): array
    {
        $this->authorize('categories-list', [$this->service->getRepository()->getSource(), $projectId]);

        return $this->service->getCategoriesList($projectId);
    }

    /**
     * @api            {get} api/project/details/{id} Детали проекта
     * @apiName        ProjectDetails
     * @apiGroup       Project
     * @apiDescription Возвращает детали проекта
     *
     * @apiUse    ResponseProject
     *
     * @param int $projectId
     * @return array
     * @throws AuthorizationException
     */
    public function details(int $projectId): array
    {
        $this->authorize('details', [$this->service->getRepository()->getSource(), $projectId]);

        return $this->service->getProjectDetails($projectId);
    }

    /**
     * @api            {get} api/project/{project_id}/category/{category_id}/divisions Список признаков изделия для проекта и категории
     * @apiName        ProjectCategoryDivisions
     * @apiGroup       Project
     * @apiDescription Возвращает список признаков изделия для проекта и категории
     *
     * @apiUse    ResponseProjectCategoryDivisions
     *
     * @param int $projectId
     * @param int $productCategoryId
     * @return array
     * @throws AuthorizationException
     */
    public function categoryDivisions(int $projectId, int $productCategoryId): array
    {
        $this->authorize('category-divisions', [$this->service->getRepository()->getSource(), $projectId]);

        return $this->service->getProjectAndCategoryDivisions($projectId, $productCategoryId);
    }

    /**
     * @api            {get} api/project/{project_id}/division/{division_id}/products Список товаров для проекта и признака
     * @apiName        ProjectDivisionProducts
     * @apiGroup       Project
     * @apiDescription Возвращает список товаров для проекта и признака
     *
     * @apiUse    ResponseProjectProducts
     *
     * @param int $projectId
     * @param int $productDivisionId
     * @return array
     * @throws AuthorizationException
     */
    public function divisionProducts(int $projectId, int $productDivisionId): array
    {
        $this->authorize('division-products', [$this->service->getRepository()->getSource(), $projectId]);

        return $this->service->getProjectAndDivisionProducts($projectId, $productDivisionId);
    }

    /**
     * @api            {delete} api/project/project_id}/product/{product_id}/delete Удалить товар из проекта
     * @apiName        ProjectProductDelete
     * @apiGroup       Project
     * @apiDescription Удаляет товар из проекта
     *
     * @apiUse    ResponseBooleanResult
     *
     * @param int $projectId
     * @param int $productId
     * @return array
     * @throws AuthorizationException
     */
    public function productDelete(int $projectId, int $productId): array
    {
        $this->authorize('delete-products', [$this->service->getRepository()->getSource(), $projectId]);

        return [
            'result' => $this->service->deleteProductFromProject($projectId, $productId),
        ];
    }

    /**
     * @api            {get} api/project/{project_id}/products Поиск товаров в проекте
     * @apiName        ProjectProductsSearch
     * @apiGroup       Project
     * @apiDescription Ищет товары в проекте
     *
     * @apiParam  {string}   [search]         Строка поиска
     *
     * @apiUse    ResponseProjectProducts
     *
     * @param int $projectId
     * @param ProjectProductsSearchRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function products(int $projectId, ProjectProductsSearchRequest $request): array
    {
        $this->authorize('search-products', [$this->service->getRepository()->getSource(), $projectId]);

        return $this->service->getProjectProducts($projectId, $request->validated());
    }

    /**
     * @api            {patch} api/project/{project_id}/product/{product_id}/update Обновить товар в проекте
     * @apiName        ProjectProductUpdate
     * @apiGroup       Project
     * @apiDescription Обновляет товар в проекте
     *
     * @apiParam  {integer}  [discount]    Скидка, %
     * @apiParam  {boolean}  [active]      0, если надо выключить активность товара
     * @apiParam  {integer}  [amount]      Кол-ство
     *
     * @apiUse    ResponseBooleanResult
     *
     * @param int $projectId
     * @param int $productId
     * @param ProjectProductUpdateRequest $request
     * @return array
     * @throws AuthorizationException
     */
    public function productUpdate(int $projectId, int $productId, ProjectProductUpdateRequest $request): array
    {
        $this->authorize('update-product', [$this->service->getRepository()->getSource(), $projectId]);

        return [
            'result' => $this->service->updateProjectProduct($projectId, $productId, $request->validated()),
        ];
    }

    /**
     * @api            {get} api/project/{project_id}/export  Получить ссылку на файл с проектом
     * @apiName        ProjectExport
     * @apiGroup       Project
     * @apiDescription Возвращает ссылку на файл с проектом
     *
     * @apiSuccess  {array}    data
     * @apiSuccess  {string}   data.url        Ссылка на файл
     *
     * @param int $projectId
     * @return array
     * @throws AuthorizationException
     */
    public function export(int $projectId): array
    {
        $this->authorize('export', [$this->service->getRepository()->getSource(), $projectId]);

        return [
            'url' => $this->filesManager->getEntityFileLink($projectId)
        ];
    }

    /**
     * @api            {post} api/project/create-from-file  Создать проект на основе файла
     * @apiName        ProjectCreateFromFile
     * @apiGroup       Project
     * @apiDescription Создает проект на основе файла
     *
     * @apiParam  {file}   file        Файл проекта. xlsx
     *
     * @apiUse    ResponseProject
     *
     * @param ProjectSpecificationFileRequest $request
     * @return mixed
     * @throws AuthorizationException
     */
    public function createProjectFromFile(ProjectSpecificationFileRequest $request)
    {
        $this->authorize('create-from-file', $this->service->getRepository()->getSource());

        return $this->service->createFromFile($request->validated()['file']);
    }

    /**
     * @api            {post} api/project/{project_id}/compare-with-file  Сравинть проект и файл
     * @apiName        ProjectImport
     * @apiGroup       Project
     * @apiDescription Сравнивает проект с данными в файле
     *
     * @apiParam  {file}   file        Файл проекта. xlsx
     *
     * @apiUse    ResponseCompareProducts
     *
     * @param int $projectId
     * @param ProjectSpecificationFileRequest $request
     * @return mixed
     * @throws AuthorizationException
     */
    public function compareWithFile(int $projectId, ProjectSpecificationFileRequest $request)
    {
        $this->authorize('compare-with-file', [$this->service->getRepository()->getSource(), $projectId]);

        return $this->service->compareWithFile($projectId, $request->validated()['file']);
    }

    /**
     * @api            {patch} api/project/{project_id}/apply-changes   Применить изменение проекта
     * @apiName        ProjectApplyChanges
     * @apiGroup       Project
     * @apiDescription Применяет изменение проекта
     *
     * @apiParam  {integer}   change_id        ID изменения
     *
     * @apiUse    ResponseBooleanResult
     *
     * @param int $projectId
     * @param ProjectProductChangesRequest $request
     * @return array
     * @throws AuthorizationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function applyChanges(int $projectId, ProjectProductChangesRequest $request): array
    {
        $projectProductChangeId = $request->validated()['change_id'];

        $this->authorize('apply-changes', [$this->service->getRepository()->getSource(), $projectId]);

        $projectProductUpdateService = app()->make(ProjectProductUpdateContract::class);
        if (!$projectProductUpdateService->checkChangeBelongToProject($projectId, $projectProductChangeId)) {
            throw new WrongArgumentException(__('project.validation.change_belong_project'));
        }

        return [
            'result' => $projectProductUpdateService->applyChanges($projectId, $projectProductChangeId),
        ];
    }
}
