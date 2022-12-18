<?php

namespace App\Domain\ServiceContracts\Project;

use App\Domain\Repositories\Project\ProjectRepository;
use App\Models\BaseModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

/**
 * Interface ProjectServiceContract
 * @package App\Domain\ServiceContracts\Project
 */
interface ProjectServiceContract
{
    /**
     * @return ProjectRepository
     */
    public function getRepository(): ProjectRepository;

    /**
     * @param ProjectRepository $repository
     */
    public function setRepository(ProjectRepository $repository);

    /**
     * @param array $params
     * @return array
     */
    public function store(array $params = []): array;

    /**
     * @param int $projectId
     * @param array $params
     * @return array
     */
    public function update(int $projectId, array $params = []): array;

    /**
     * @param int $projectId
     * @param array $params
     * @return bool
     */
    public function updateProjectContacts(int $projectId, array $params = []): bool;

    /**
     * @param int $projectId
     * @param array $params
     * @return bool
     */
    public function updateProjectAttributes(int $projectId, array $params = []): bool;

    /**
     * @param int $projectId
     * @return bool
     */
    public function delete(int $projectId): bool;

    /**
     * @param int $projectId
     * @return array
     */
    public function getProjectDetails(int $projectId): array;

    /**
     * @param array $params
     * @return array
     */
    public function getUserProjectsList(array $params = []): array;

    /**
     * @param array $params
     * @return bool
     */
    public function addProductToProjects(array $params = []): bool;

    /**
     * @param int $projectId
     * @param array $params
     * @return bool
     */
    public function addCategoryToProject(int $projectId, array $params = []): bool;

    /**
     * @param int $projectId
     * @return array
     */
    public function getCategoriesList(int $projectId): array;

    /**
     * @param int $projectId
     * @param int $productCategoryId
     * @return array
     */
    public function getProjectAndCategoryDivisions(int $projectId, int $productCategoryId): array;

    /**
     * @param int $projectId
     * @param int $productDivisionId
     * @return array
     */
    public function getProjectAndDivisionProducts(int $projectId, int $productDivisionId): array;

    /**
     * @param int $projectId
     * @param int $productId
     * @return bool
     */
    public function deleteProductFromProject(int $projectId, int $productId): bool;

    /**
     * @param int $projectId
     * @param array $params
     * @param bool $activeOnly
     * @return array
     */
    public function getProjectProducts(int $projectId, array $params = [], bool $activeOnly = false): array;

    /**
     * @param int $projectId
     * @return array
     */
    public function getProjectSpecifications(int $projectId): array;

    /**
     * @param int $projectId
     * @return array
     */
    public function createProjectSpecification(int $projectId): array;

    /**
     * @param int $projectId
     * @param bool $activeOnly
     * @return Collection
     */
    public function getNotUsedProducts(int $projectId, bool $activeOnly = false): Collection;

    /**
     * @param int $projectId
     * @param int $productId
     * @param bool $withException
     * @return BaseModel|null
     */
    public function getProjectProduct(int $projectId, int $productId, bool $withException = true): ?BaseModel;

    /**
     * @param int $specificationId
     * @param int $specificationProductId
     * @return BaseModel
     */
    public function getProjectBySpecificationAndSpecificationProduct(int $specificationId, int $specificationProductId): BaseModel;

    /**
     * @param int $projectId
     * @param int $productId
     * @param array $params
     * @return bool
     */
    public function updateProjectProduct(int $projectId, int $productId, array $params): bool;

    /**
     * Создаем проект. Заполняем его товарами. Заполняем спецификацию. Все на основе файла-выгрузки
     *
     * @param UploadedFile $file
     * @return mixed
     */
    public function createFromFile(UploadedFile $file);

    /**
     * Сравнивает товары в файле и в проекте
     *
     * @param int $projectId
     * @param UploadedFile $file
     * @return mixed
     */
    public function compareWithFile(int $projectId, UploadedFile $file);

    /**
     * @param int $projectId
     * @param int $productId
     * @return bool
     */
    public function updateProjectSpecificationProduct(int $projectId, int $productId): bool;

    /**
     * @param int $projectId
     */
    public function reCalcProject(int $projectId): void;

    /**
     * @param string $session
     * @return array
     */
    public function getProjectsBySession(string $session): array;

    /**
     * @param int $projectId
     * @return bool
     */
    public function getOwnerPermission(int $projectId): bool;

    /**
     * @param int $projectId
     * @return mixed
     */
    public function addCurrentUserActivity(int $projectId);

    /**
     * @param int $projectId
     * @param int $categoryId
     * @return bool
     */
    public function deleteCategoryFromProject(int $projectId, int $categoryId): bool;
}
