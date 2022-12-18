<?php

namespace App\Domain\ServiceContracts\Project;

use App\Domain\Repositories\Project\ProjectProductUpdateRepository;
use App\Models\Project\ProjectProductChange;
use App\Utils\ProductChangers\Watchers\ProjectProductsChangesCollection;
use Illuminate\Support\Collection;

/**
 * Interface ProjectProductUpdateContract
 * @package App\Domain\ServiceContracts\Project
 */
interface ProjectProductUpdateContract
{
    /**
     * @return ProjectProductUpdateRepository
     */
    public function getRepository(): ProjectProductUpdateRepository;

    /**
     * @param int $entityId
     * @return ProjectProductChange
     */
    public function getDetails(int $entityId): ProjectProductChange;

    /**
     * Сравнивает товары в проекте с коллекцией товаров.
     *
     * @param int $projectId
     * @param Collection $products
     * @return ProjectProductsChangesCollection
     */
    public function compareProjectProducts(int $projectId, Collection $products): ProjectProductsChangesCollection;

    /**
     * Применить измение в товаре проекта
     *
     * @param int $projectId
     * @param int $projectProductChangeId
     * @return bool
     */
    public function applyChanges(int $projectId, int $projectProductChangeId): bool;

    /**
     * Принадлежит ли это изменение проекту
     *
     * @param int $projectId
     * @param int $projectProductChangeId
     * @return bool
     */
    public function checkChangeBelongToProject(int $projectId, int $projectProductChangeId): bool;
}
