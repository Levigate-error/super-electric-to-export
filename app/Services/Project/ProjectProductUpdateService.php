<?php

namespace App\Services\Project;

use App\Domain\ServiceContracts\AnalogueServiceContract;
use App\Domain\ServiceContracts\ProductServiceContract;
use App\Services\BaseService;
use App\Domain\ServiceContracts\Project\ProjectProductUpdateContract;
use App\Domain\ServiceContracts\Project\ProjectServiceContract;
use App\Domain\Repositories\Project\ProjectProductUpdateRepository;
use Illuminate\Support\Collection;
use App\Utils\ProductChangers\Watchers\ProjectProductsChangesCollection;
use App\Domain\Dictionaries\Utils\ProductChangers\ProjectProductChangeTypes;
use App\Domain\Dictionaries\Utils\ProductChangers\BaseChangeTypes;
use Illuminate\Support\Str;
use App\Utils\ProductChangers\Watchers\ProjectProductsCompareMapper;
use App\Models\Project\ProjectProductChange;
use App\Utils\ProductChangers\Resolvers\ResolveChangesManager;
use App\Domain\UtilContracts\ProductChangers\Resolvers\Contracts\ProjectProductChangesDriverContract;

/**
 * Class ProjectProductUpdateService
 * @package App\Services\Project
 */
class ProjectProductUpdateService extends BaseService implements ProjectProductUpdateContract
{
    /**
     * @var ProjectProductUpdateRepository
     */
    private $repository;

    /**
     * ProjectProductUpdateService constructor.
     * @param ProjectProductUpdateRepository $repository
     */
    public function __construct(ProjectProductUpdateRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return ProjectProductUpdateRepository
     */
    public function getRepository(): ProjectProductUpdateRepository
    {
        return $this->repository;
    }

    /**
     * @param int $entityId
     * @return ProjectProductChange
     */
    public function getDetails(int $entityId): ProjectProductChange
    {
        return $this->repository->getDetails($entityId);
    }

    /**
     * Сравнивает товары в проекте с коллекцией товаров.
     *
     * @param int $projectId
     * @param Collection $products
     * @return ProjectProductsChangesCollection
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function compareProjectProducts(int $projectId, Collection $products): ProjectProductsChangesCollection
    {
        $mapper = new ProjectProductsCompareMapper();
        $projectService = app()->make(ProjectServiceContract::class);
        $projectProducts = collect($projectService->getProjectProducts($projectId, [], true));

        return $this->compareProcessing($projectId, $projectProducts, $products, 'vendor_code', $mapper->getMap('vendor_code'));
    }

    /**
     * Механизм сравнение коллекций товаров.
     * Сравнение происходит по товарам с одинаковым $uniqueKey на основе мапы $compareMap.
     *
     * @param int $projectId
     * @param Collection $oldCollection
     * @param Collection $newCollection
     * @param string $uniqueKey
     * @param array $compareMap
     * @return ProjectProductsChangesCollection
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function compareProcessing(int $projectId, Collection $oldCollection, Collection $newCollection, string $uniqueKey, array $compareMap): ProjectProductsChangesCollection
    {
        $changes = new ProjectProductsChangesCollection();

        $newCollection = $newCollection->keyBy($uniqueKey);
        $oldCollection = $oldCollection->keyBy($uniqueKey);

        $analogService = $this->getService(AnalogueServiceContract::class);
        $productService = $this->getService(ProductServiceContract::class);

        /**
         * Проходимся по разнице между загружаемыми товарами (например из файла со спецификацией) и
         * текущими товарами в БД в проекте. Такие помечаем для добавления в проект.
         */
        foreach ($newCollection->diffKeys($oldCollection) as $addedProduct) {
            $realProduct = $productService->getProductByParam([$uniqueKey => $addedProduct[$uniqueKey]]);

            /**
             * Если такого товара у нас нет, то смотрим в аналогах. Если и в аналогах нет, то пропускаем.
             */
            if ($realProduct === null) {
                $ourProduct = $analogService->getFirstProductByParams([$uniqueKey => $addedProduct[$uniqueKey]]);

                if ($ourProduct !== null) {
                    $changes->pushAnalog($projectId, $addedProduct['vendor_code'], $ourProduct['vendor_code'], $addedProduct['name'], $addedProduct);
                }

                continue;
            }

            $changes->pushAdded($projectId, $addedProduct['vendor_code'], $addedProduct['name'], $addedProduct);
        }

        /**
         * Проходимся по разнице между текущими товарами в БД в проекте коллекций и загружаемыми
         * товарами (например из файла со спецификацией).
         *
         * Такие помечаем для удаления из проекта.
         */
        foreach ($oldCollection->diffKeys($newCollection) as $removedProduct) {
            $changes->pushRemoved($projectId, $removedProduct['vendor_code'], $removedProduct['name'], $removedProduct['id']);
        }

        /**
         * Сравниваем значения свойств товаров
         */
        foreach ($newCollection as $key => $value) {
            $inOldCollection = $oldCollection->get($key);
            if (empty($inOldCollection)) {
                continue;
            }

            /**
             * $compareMap - карта свойств товара, которые необходимо сравнивать.
             */
            foreach ($compareMap as $compareKey) {
                if (!isset($compareKey['key']) || !isset($compareKey['type'])) {
                    continue;
                }

                $newValue = $value[$compareKey['key']];
                $oldValue = $inOldCollection[$compareKey['key']];

                if ($compareKey['type'] === BaseChangeTypes::BOOLEAN) {
                    $newValue = $newValue === __('project.file.boolean_check_word');
                }

                if ($newValue != $oldValue) {
                    $changesDetails = $this->getChangesDetails($newValue, $oldValue, $compareKey);

                    $changes->pushChange($projectId, $inOldCollection['vendor_code'], $inOldCollection['name'],
                        $changesDetails, $inOldCollection['id'], $value, $oldValue, $newValue
                    );
                }
            }
        }

        return $changes;
    }

    /**
     * Формирует тип различия
     *
     * @param $newValue
     * @param $oldValue
     * @param array $compareKey
     * @return string
     */
    protected function getChangesDetails($newValue, $oldValue, array $compareKey): string
    {
        $compare = '';

        switch ($compareKey['type']) {
            case BaseChangeTypes::NUMERIC:
                $compare = ($newValue < $oldValue) ? 'down' : 'up';
                break;
            case BaseChangeTypes::BOOLEAN:
                $compare = !$newValue ? 'no' : 'yes';
                break;
        }

        $changeType = Str::upper($compareKey['key'] . '_' . $compare);

        return constant(ProjectProductChangeTypes::class."::$changeType");
    }

    /**
     * @param int $projectId
     * @param int $projectProductChangeId
     * @return bool
     */
    public function applyChanges(int $projectId, int $projectProductChangeId): bool
    {
        $projectProductChange = $this->getDetails($projectProductChangeId);

        /**
         * @var $resolver ProjectProductChangesDriverContract
         */
        $resolver = (new ResolveChangesManager(app()))->driver($projectProductChange->type);

        return $resolver->resolve($projectProductChange);
    }

    /**
     * Принадлежит ли это изменение проекту
     *
     * @param int $projectId
     * @param int $projectProductChangeId
     * @return bool
     */
    public function checkChangeBelongToProject(int $projectId, int $projectProductChangeId): bool
    {
        $projectProductChange = $this->getDetails($projectProductChangeId);

        return $projectProductChange->project_id === $projectId;
    }
}
