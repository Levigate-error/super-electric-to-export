<?php

namespace App\Services\Project;

use App\Domain\ServiceContracts\Project\ProjectSpecificationProductServiceContract;
use App\Services\BaseService;
use App\Domain\ServiceContracts\Project\ProjectServiceContract;
use App\Domain\ServiceContracts\ProductServiceContract;
use App\Domain\ServiceContracts\Project\ProjectSpecificationServiceContract;
use App\Domain\ServiceContracts\Project\ProjectProductUpdateContract;
use App\Domain\Repositories\Project\ProjectRepository;
use App\Domain\Repositories\Project\ProjectSpecificationProductRepository;
use App\Domain\Repositories\ProductCategoryRepository;
use App\Http\Resources\ProductDivisionResource;
use App\Http\Resources\Project\ProjectResource;
use App\Http\Resources\ProductCategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\Project\ProjectSpecificationResource;
use App\Models\BaseModel;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exceptions\WrongArgumentException;
use App\Domain\UtilContracts\Files\FilesManagerContract;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Project\ProjectProductUpdateResource;
use App\Traits\ServiceGetter;
use App\Exceptions\CanNotDeleteException;

/**
 * Class ProjectService
 * @package App\Services
 */
class ProjectService extends BaseService implements ProjectServiceContract
{
    use ServiceGetter;

    /**
     * @var ProjectRepository
     */
    private $repository;

    /**
     * @var ProductServiceContract
     */
    private $productService;

    /**
     * ProjectService constructor.
     * @param ProjectRepository $repository
     * @param ProductServiceContract $productService
     */
    public function __construct(ProjectRepository $repository, ProductServiceContract $productService)
    {
        $this->setRepository($repository);
        $this->setProductService($productService);
    }

    /**
     * @return ProjectRepository
     */
    public function getRepository(): ProjectRepository
    {
        return $this->repository;
    }

    /**
     * @param ProjectRepository $repository
     */
    public function setRepository(ProjectRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ProductServiceContract $productService
     */
    public function setProductService(ProductServiceContract $productService): void
    {
        $this->productService = $productService;
    }

    /**
     * @param array $params
     * @return array
     */
    public function store(array $params = []): array
    {
        if (Auth::user() !== null) {
            $params['user_id'] = Auth::user()->id;
        }

        if (isset($params['user_id']) === false) {
            $sessionProjects = $this->getProjectsBySession(Auth::guard()->getSession()->getId());

            if (empty($sessionProjects) === false) {
                throw new WrongArgumentException(trans('project.validation.one_project_for_guest'));
            }
        }

        $project = $this->repository->getSource()::create($params);
        $this->createProjectSpecification($project->id);

        return ProjectResource::make($project)->resolve();
    }

    /**
     * @param int $projectId
     * @param array $params
     * @return array
     */
    public function update(int $projectId, array $params = []): array
    {
        $source = $this->repository->getSource();

        return ProjectResource::make($source::updateProject($projectId, $params))->resolve();
    }

    /**
     * @param int $projectId
     * @param array $params
     * @return bool
     */
    public function updateProjectContacts(int $projectId, array $params = []): bool
    {
        return $this->repository->getSource()::updateContacts($projectId, $params);
    }

    /**
     * @param int $projectId
     * @param array $params
     * @return bool
     */
    public function updateProjectAttributes(int $projectId, array $params = []): bool
    {
        return $this->repository->getSource()::updateAttributes($projectId, $params);
    }

    /**
     * @param int $projectId
     * @return bool
     */
    public function delete(int $projectId): bool
    {
        $source = $this->repository->getSource();

        return $source::deleteProject($projectId);
    }

    /**
     * @param int $projectId
     * @return array
     */
    public function getProjectDetails(int $projectId): array
    {
        return ProjectResource::make($this->repository->getProjectDetails($projectId))->resolve();
    }

    /**
     * @param array $params
     * @return array
     */
    public function getUserProjectsList(array $params = []): array
    {
        $limit = $params['limit'] ?? 15;
        unset($params['limit'], $params['page']);

        $source = $this->repository->getSource();
        $params = array_merge($params, $source::getConditionsForOwner());

        $projects = $this->repository->getProjectsByParams($limit, $params);

        return [
            'total' => $projects->total(),
            'lastPage' => $projects->lastPage(),
            'currentPage' => $projects->currentPage(),
            'projects' => ProjectResource::collection($projects)->resolve(),
        ];
    }

    /**
     * @param array $params
     * @return bool
     */
    public function addProductToProjects(array $params = []): bool
    {
        foreach ($params['projects'] as $projectKey => $projectValue) {
            $projectProduct = $this->getProjectProduct($projectValue['project'], $params['product'], false);

            /**
             * Если в проекте уже есть такой товар, то заново не добавляем
             */
            if (!empty($projectProduct)) {
                unset($params['projects'][$projectKey]);
            }
        }

        return $this->repository->getSource()::addProductToProjects($params['product'], $params['projects']);
    }

    /**
     * @param int $projectId
     * @param array $params
     * @return bool
     */
    public function addCategoryToProject(int $projectId, array $params = []): bool
    {
        return $this->repository->getSource()::addCategory($projectId, $params['product_category']);
    }

    /**
     * @param int $projectId
     * @return array
     */
    public function getCategoriesList(int $projectId): array
    {
        $collection = $this->repository->getProjectCategories($projectId);

        return ProductCategoryResource::collection($collection)->resolve();
    }

    /**
     * @param int $projectId
     * @param int $productCategoryId
     * @return array
     * @throws BindingResolutionException
     */
    public function getProjectAndCategoryDivisions(int $projectId, int $productCategoryId): array
    {
        $productCategoryRepository = app()->make(ProductCategoryRepository::class);

        $divisions = $productCategoryRepository->getDivisions($productCategoryId);

        $divisions->map(function($productDivision) use ($projectId) {
            $productDivision->product_amount = $this->repository->getProductAmountInDivision($projectId, $productDivision->id);
        });

        return ProductDivisionResource::collection($divisions)->resolve();
    }

    /**
     * @param int $projectId
     * @param int $productDivisionId
     * @return array
     */
    public function getProjectAndDivisionProducts(int $projectId, int $productDivisionId): array
    {
        $products = $this->repository->getProjectAndDivisionProducts($projectId, $productDivisionId);

        return $this->getTranslatedProductsResource($products);
    }

    /**
     * @param Collection $products
     * @return array
     */
    private function getTranslatedProductsResource(Collection $products): array
    {
        /**
         * TODO
         * Отрефакторить. Вынести переводы в отдельный слой
         */
        foreach ($products as $product) {
            $product->attributes = $product->features;
            $product->amount = $product->pivot->amount;
            $this->productService->translateProductWithParams($product);
        }

        return ProductResource::collection($products)->resolve();
    }

    /**
     * @param int $projectId
     * @param int $productId
     * @return bool
     */
    public function deleteProductFromProject(int $projectId, int $productId): bool
    {
        $productUsedAmount = $this->repository->getProjectProductUsedAmount($projectId, $productId);

        /**
         * Если товар уже используется в спецификации, то его нельзя удалить из проекта на прямую
         */
        if ($productUsedAmount !== 0) {
            throw new WrongArgumentException(__('project.validation.product_used_in_specification'));
        }

        return $this->repository->getSource()::deleteProductFromProject($projectId, $productId);
    }

    /**
     * @param int $projectId
     * @param array $params
     * @param bool $activeOnly
     * @return array
     */
    public function getProjectProducts(int $projectId, array $params = [], bool $activeOnly = false): array
    {
        $products = $this->repository->getProjectProductsByParams($projectId, array_merge($params, ['active' => $activeOnly]));

        return $this->getTranslatedProductsResource($products);
    }

    /**
     * @param int $projectId
     * @return array
     */
    public function getProjectSpecifications(int $projectId): array
    {
        $specifications = $this->repository->getProjectSpecifications($projectId);

        return ProjectSpecificationResource::make($specifications)->resolve();
    }

    /**
     * @param int $projectId
     * @return array
     */
    public function createProjectSpecification(int $projectId): array
    {
        $source = $this->repository->getSource();
        $specification = $source::createSpecification($projectId);

        return ProjectSpecificationResource::make($specification)->resolve();
    }

    /**
     * @param int $projectId
     * @param bool $activeOnly
     * @return Collection
     */
    public function getNotUsedProducts(int $projectId, bool $activeOnly = false): Collection
    {
        return $this->repository->getNotUsedProducts($projectId, $activeOnly);
    }

    /**
     * @param int $projectId
     * @param int $productId
     * @param bool $withException
     * @return BaseModel|null
     */
    public function getProjectProduct(int $projectId, int $productId, bool $withException = true): ?BaseModel
    {
        return $this->repository->getProjectProduct($projectId, $productId, $withException);
    }

    /**
     * @param int $specificationId
     * @param int $specificationProductId
     * @return BaseModel
     */
    public function getProjectBySpecificationAndSpecificationProduct(int $specificationId, int $specificationProductId): BaseModel
    {
        return $this->repository->getProjectBySpecificationAndSpecificationProduct($specificationId, $specificationProductId);
    }

    /**
     * @param int $projectId
     * @param int $productId
     * @param array $params
     * @return bool
     */
    public function updateProjectProduct(int $projectId, int $productId, array $params): bool
    {
        $projectProduct = $this->getProjectProduct($projectId, $productId);

        /**
         * Новое кол-ство товара не должно быть меньшим, чем кол-ство товара уже используемого в разделах спецификации.
         */
        if (isset($params['amount'])) {
            $params['amount'] = $this->applyAmountFilter($params['amount']);

            $minAmount = $projectProduct->pivot->amount - $projectProduct->pivot->not_used_amount;
            if ($params['amount'] < $minAmount) {
                throw new WrongArgumentException(__('project.validation.min_product_amount', ['min_amount' => $minAmount]));
            }
        }

        return $this->repository->getSource()::updateProjectProduct($projectId, $productId, $params);
    }

    /**
     * @param int $projectId
     * @param int $productId
     * @param int $amount
     * @return array
     */
    public function prepareProductDataToAdd(int $projectId, int $productId, int $amount): array
    {
        return [
            'product' => $productId,
            'projects' => [
                [
                    'project' => $projectId,
                    'amount' => $amount,
                ],
            ],
        ];
    }

    /**
     * @param UploadedFile $file
     * @return array|JsonResponse|Collection|mixed
     * @throws BindingResolutionException
     */
    public function createFromFile(UploadedFile $file)
    {
        $fileData = $this->checkAndParseProjectFile($file);
        if ($fileData instanceof JsonResponse) {
            return $fileData;
        }

        DB::beginTransaction();

        /**
         * Создаем новый проект
         */
        $project = $this->store();

        /**
         * Перекладываем механизм добавления товаров на механизм создания изменений между проектом и файлом.
         * Нужно, чтобы через один механизм проходило при работе с файлом проекта.
         */
        $productsChanges = $this->compareWithFile($project['id'], $file);
        foreach ($productsChanges as $productChange) {
            $projectUpdateService = app()->make(ProjectProductUpdateContract::class);
            $projectUpdateService->applyChanges($project['id'], $productChange['id']);
        }

        if ($fileData->has('specification')) {
            $this->fileSpecificationProcessing($fileData->get('specification'), $project['id']);
        }

        DB::commit();

        return $this->getProjectDetails($project['id']);
    }

    /**
     * Обрабатываем вкладку со спецификацией
     *
     * @param Collection $specificationData
     * @param int $projectId
     * @throws BindingResolutionException
     */
    private function fileSpecificationProcessing(Collection $specificationData, int $projectId): void
    {
        $specificationService = app()->make(ProjectSpecificationServiceContract::class);
        $specification = $this->getProjectSpecifications($projectId);

        /**
         * Создаем разделы спецификации и переносим товары
         */
        $sections = $specificationData->groupBy('section');
        foreach ($sections as $sectionName => $sectionProducts) {
            /**
             * Если это раздел с нераспределенной продукцией, то пропускаем этот шаг для него
             */
            if ($sectionName === __('project.fake_section')) {
                continue;
            }

            $specificationSection = $specificationService->addSpecificationSection($specification['id'], ['title' => $sectionName]);

            foreach ($sectionProducts as $sectionProduct) {
                $realProduct = $this->productService->getProductByParam(['vendor_code' => $sectionProduct['vendor_code']]);
                $projectProduct = $this->getProjectProduct($projectId, $realProduct['id'], false);

                if ($projectProduct === null) {
                    continue;
                }

                $paramsToMoveProduct = [
                    'product' => $realProduct['id'],
                    'section' => $specificationSection->id,
                    'amount' => $sectionProduct['amount'],
                ];

                $specificationService->moveProduct($specification['id'], $paramsToMoveProduct);
            }
        }
    }

    /**
     * Сравнивает товары в файле и в проекте
     *
     * @param int $projectId
     * @param UploadedFile $file
     * @return array|JsonResponse
     * @throws BindingResolutionException
     */
    public function compareWithFile(int $projectId, UploadedFile $file)
    {
        $fileData = $this->checkAndParseProjectFile($file);
        if ($fileData instanceof JsonResponse) {
            return $fileData;
        }

        $changes = new Collection();
        if ($fileData->has('products')) {
            $fileProducts = $fileData->get('products');
            $projectUpdateService = app()->make(ProjectProductUpdateContract::class);

            $compareResults = $projectUpdateService->compareProjectProducts($projectId, $fileProducts);
            if ($compareResults->isNotEmpty()) {
                $changes = $projectUpdateService->getRepository()->getSource()::addChanges($compareResults);
            }
        }

        return ProjectProductUpdateResource::collection($changes)->resolve();
    }

    /**
     * Валидирует файл и парсит данные из него
     *
     * @param UploadedFile $file
     * @return JsonResponse|Collection
     * @throws BindingResolutionException
     */
    protected function checkAndParseProjectFile(UploadedFile $file)
    {
        $fileManager = app()->make(FilesManagerContract::class);

        /**
         * Проверяем файл на ошибки
         * @var $errors Collection
         */
        $errors = $fileManager->checkFile($file);
        if ($errors->isNotEmpty()) {
            return response()->json($errors, 422);
        }

        /**
         * Собираем данные из файла
         */
        return $fileManager->getFileData($file);
    }

    /**
     * Обновляет данные товара внтури спецификации.
     * Используется при инициации обновления параметров со стороны товара в проекте, что влечет за собой изменение и
     * параметров внутри спецификации.
     *
     * @param int $projectId
     * @param int $productId
     * @return bool
     * @throws BindingResolutionException
     */
    public function updateProjectSpecificationProduct(int $projectId, int $productId): bool
    {
        $specificationService = $this->getService(ProjectSpecificationServiceContract::class);
        $specificationProductService = $this->getService(ProjectSpecificationProductServiceContract::class);

        $specification = $this->getProjectSpecifications($projectId);
        $projectProduct = $this->getProjectProduct($projectId, $productId);
        $specificationProducts = $specificationProductService->getSpecificationProductsByProduct($specification['id'], $productId);

        DB::beginTransaction();

        foreach ($specificationProducts as $specificationProduct) {
            $params = [
                'real_price' => $projectProduct->pivot->real_price,
                'discount' => $projectProduct->pivot->discount,
                'in_stock' => $projectProduct->pivot->in_stock,
            ];

            $specificationService->updateProduct($specification['id'], $specificationProduct->id, $params);
        }

        DB::commit();

        return true;
    }

    /**
     * Пересчет проекта.
     *
     * @param int $projectId
     * @throws BindingResolutionException
     */
    public function reCalcProject(int $projectId): void
    {
        /**
         * Пересчитываем товары в спецификации
         */
        $specification = $this->getProjectSpecifications($projectId);

        $projectSpecificationProductsSum = 0;

        if (isset($specification['id']) === true) {
            $specificationService = $this->getService(ProjectSpecificationServiceContract::class);

            $specificationService->reCalcSpecification($specification['id']);

            /**
             * Подсчет стоимости товаров в спецификаии
             */
            $specificationProductRepo = app()->make(ProjectSpecificationProductRepository::class);

            $projectSpecificationProductsSum = $specificationProductRepo
                ->getProjectSpecificationProducts($projectId, $specification['id'])
                ->sum('total_price');
        }

        /**
         * Подсчет стоимости товаров в проекте, которые не используются в спецификации
         */
        $notUsedProductsSum = $this
            ->getNotUsedProducts($projectId, true)
            ->sum(static function ($product) {
                return $product->pivot->not_used_amount * $product->pivot->price_with_discount;
            });

        $totalPrice = round($projectSpecificationProductsSum + $notUsedProductsSum, 2);

        $this->repository->getSource()::updateOnlyProject($projectId, ['total_price' => $totalPrice]);
    }

    /**
     * @param string $session
     * @return array
     */
    public function getProjectsBySession(string $session): array
    {
        $sessionProjects = $this->repository->getProjectsBySession($session);

        return ProjectResource::collection($sessionProjects->untype())->resolve();
    }

    /**
     * @param int $projectId
     * @return bool
     */
    public function getOwnerPermission(int $projectId): bool
    {
        $project = $this->repository->getSource()::query()->findOrFail($projectId);

        return $project->checkOwnerPermission();
    }


    /**
     * @param $amount
     * @return int
     */
    protected function applyAmountFilter($amount): int
    {
        $amount = (int) $amount;
        $modelClass = $this->repository->getSource();

        if ($amount < $modelClass::MIN_AMOUNT) {
            $amount = $modelClass::MIN_AMOUNT;
        }

        if ($amount > $modelClass::MAX_AMOUNT) {
            $amount = $modelClass::MAX_AMOUNT;
        }

        return $amount;
    }

    /**
     * @param int $projectId
     * @return mixed
     */
    public function addCurrentUserActivity(int $projectId)
    {
        $user = Auth::user();

        if ($user === null) {
            return false;
        }

        return $user->projectsActivities()->create([
            'source_id' => $projectId,
            'source_type' => $this->repository->getSource(),
        ]);
    }

    /**
     * @param int $projectId
     * @param int $categoryId
     * @return bool
     */
    public function deleteCategoryFromProject(int $projectId, int $categoryId): bool
    {
        $projectCategoryProducts = $this->repository->getProjectAndCategoryProducts($projectId, $categoryId);

        /**
         * Если в проекте есть товары из этой категории, то категорию нельзя удалять из проекта
         */
        if ($projectCategoryProducts->isNotEmpty() === true) {
            throw new WrongArgumentException(__('project.validation.category_has_products'));
        }

        if ($this->repository->getSource()::deleteCategoryFromProject($projectId, $categoryId) === false) {
            throw new CanNotDeleteException();
        }

        return true;
    }
}
