<?php

namespace App\Domain\ServiceContracts\Project;

use App\Domain\Repositories\Project\ProjectSpecificationRepository;
use App\Models\BaseModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

/**
 * Interface ProjectSpecificationServiceContract
 * @package App\Domain\ServiceContracts
 */
interface ProjectSpecificationServiceContract
{
    /**
     * @return ProjectSpecificationRepository
     */
    public function getRepository(): ProjectSpecificationRepository;

    /**
     * @param ProjectSpecificationRepository $repository
     * @return mixed
     */
    public function setRepository(ProjectSpecificationRepository $repository);

    /**
     * @param UploadedFile $file
     * @return mixed
     */
    public function checkFile(UploadedFile $file);

    /**
     * @return array
     */
    public function getFileExample(): array;

    /**
     * @param int $specificationId
     * @param bool $activeOnly
     * @return array
     */
    public function getSpecificationSectionsList(int $specificationId, bool $activeOnly = false): array;

    /**
     * @param int $specificationId
     * @param bool $activeOnly
     * @return array
     */
    public function getSectionWithNotUsedProductsBySpecification(int $specificationId, bool $activeOnly = false): array;

    /**
     * @param int $specificationId
     * @param array $params
     * @return BaseModel
     */
    public function addSpecificationSection(int $specificationId, array $params): BaseModel;

    /**
     * @param int $specificationId
     * @param array $params
     * @return bool
     */
    public function moveProduct(int $specificationId, array $params): bool;

    /**
     * @param int $productId
     * @param int $specificationId
     * @return bool
     */
    public function updateNotUsedProductAmount(int $productId, int $specificationId): bool;

    /**
     * @param int $specificationId
     * @param int $projectSpecificationProductId
     * @param array $params
     * @return bool
     */
    public function updateProduct(int $specificationId, int $projectSpecificationProductId, array $params): bool;

    /**
     * @param int $productId
     * @param int $specificationId
     * @return bool
     */
    public function reCalcProductData(int $productId, int $specificationId): bool;

    /**
     * @param int $productId
     * @param int $specificationId
     * @return bool
     */
    public function reCalcProductPrice(int $productId, int $specificationId): bool;

    /**
     * @param int $specificationId
     * @param int $projectSpecificationProductId
     * @return bool
     */
    public function checkProductBelongToSpecification(int $specificationId, int $projectSpecificationProductId): bool;

    /**
     * @param int $projectSpecificationProductId
     * @return bool
     */
    public function deleteProduct(int $projectSpecificationProductId): bool;

    /**
     * @param int $specificationId
     * @return bool
     */
    public function reCalcSpecification(int $specificationId): bool;

    /**
     * @param Collection $products
     * @param int $specificationId
     * @return bool
     */
    public function reCalcProductsInSpecification(Collection $products, int $specificationId): bool;

    /**
     * @param int $specificationId
     * @param int $specificationSectionId
     * @return bool
     */
    public function checkSectionBelongToSpecification(int $specificationId, int $specificationSectionId): bool;

    /**
     * @param int $specificationSectionId
     * @return bool
     */
    public function deleteSection(int $specificationSectionId): bool;

    /**
     * @param int $specificationSectionId
     * @param array $params
     * @return bool
     */
    public function updateSection(int $specificationSectionId, array $params): bool;

    /**
     * @param int $specificationSectionId
     * @param int $specificationProductId
     * @return bool
     */
    public function checkProductBelongToSpecificationSection(int $specificationSectionId, int $specificationProductId): bool;

    /**
     * @param int $specificationId
     * @param array $params
     * @return bool
     */
    public function replaceProduct(int $specificationId, array $params): bool;

    /**
     * @param int $specificationId
     * @param int $specificationSectionId
     * @param array $params
     * @return bool
     */
    public function addProductToSpecificationSection(int $specificationId, int $specificationSectionId, array $params): bool;
}
