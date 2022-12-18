<?php

namespace App\Services\Project;

use App\Services\BaseService;
use App\Models\BaseModel;
use App\Utils\Files\Notice\NoticeCollection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use App\Domain\Repositories\Project\ProjectSpecificationRepository;
use App\Domain\ServiceContracts\Project\ProjectSpecificationServiceContract;
use App\Domain\ServiceContracts\Project\ProjectServiceContract;
use App\Domain\ServiceContracts\Project\ProjectSpecificationProductServiceContract;
use App\Domain\ServiceContracts\Project\ProjectSpecificationSectionServiceContract;
use App\Domain\UtilContracts\Files\FilesManagerContract;
use App\Http\Resources\Project\ProjectSpecificationProductResource;
use App\Http\Resources\Project\ProjectSpecificationSectionResource;
use Illuminate\Support\Facades\DB;

/**
 * Class ProjectSpecificationService
 * @package App\Services
 */
class ProjectSpecificationService extends BaseService implements ProjectSpecificationServiceContract
{
    /**
     * @var ProjectSpecificationRepository
     */
    private $repository;

    /**
     * @var FilesManagerContract
     */
    private $fileManager;

    /**
     * @var ProjectServiceContract
     */
    private $projectService;

    /**
     * @var ProjectSpecificationProductServiceContract
     */
    private $specificationProductService;

    /**
     * @var ProjectSpecificationSectionServiceContract
     */
    private $specificationSectionService;

    /**
     * ProjectSpecificationService constructor.
     * @param ProjectSpecificationRepository $repository
     * @param FilesManagerContract $filesManager
     * @param ProjectServiceContract $projectService
     * @param ProjectSpecificationProductServiceContract $specificationProductService
     * @param ProjectSpecificationSectionServiceContract $specificationSectionService
     */
    public function __construct(
        ProjectSpecificationRepository $repository,
        FilesManagerContract $filesManager,
        ProjectServiceContract $projectService,
        ProjectSpecificationProductServiceContract $specificationProductService,
        ProjectSpecificationSectionServiceContract $specificationSectionService
    )
    {
        $this->setRepository($repository);
        $this->setFileManager($filesManager);
        $this->setProjectService($projectService);
        $this->setSpecificationProductService($specificationProductService);
        $this->setSpecificationSectionService($specificationSectionService);

    }

    /**
     * @return ProjectSpecificationRepository
     */
    public function getRepository(): ProjectSpecificationRepository
    {
        return $this->repository;
    }

    /**
     * @param ProjectSpecificationRepository $repository
     * @return mixed|void
     */
    public function setRepository(ProjectSpecificationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param FilesManagerContract $filesManager
     */
    public function setFileManager(FilesManagerContract $filesManager)
    {
        $this->fileManager = $filesManager;
    }

    /**
     * @param ProjectServiceContract $projectService
     */
    public function setProjectService(ProjectServiceContract $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * @param ProjectSpecificationProductServiceContract $specificationProductService
     */
    public function setSpecificationProductService(ProjectSpecificationProductServiceContract $specificationProductService)
    {
        $this->specificationProductService = $specificationProductService;
    }

    /**
     * @param ProjectSpecificationSectionServiceContract $specificationSectionService
     */
    public function setSpecificationSectionService(ProjectSpecificationSectionServiceContract $specificationSectionService)
    {
        $this->specificationSectionService = $specificationSectionService;
    }

    /**
     * @param UploadedFile $file
     * @return array|\Illuminate\Http\JsonResponse|mixed
     */
    public function checkFile(UploadedFile $file)
    {
        /**
         * @var $checkErrors NoticeCollection
         */
        $checkErrors = $this->fileManager->checkFile($file);

        if (!$checkErrors->isEmpty()) {
            return response()->json($checkErrors, 422);
        }

        return [
            'result' => true,
        ];
    }

    /**
     * @return array
     */
    public function getFileExample(): array
    {
        return [
            'url' => $this->fileManager->getUrlOfFileExample(),
        ];
    }

    /**
     * @param int $specificationId
     * @param bool $activeOnly
     * @return array
     */
    public function getSpecificationSectionsList(int $specificationId, bool $activeOnly = false): array
    {
        $sections = $this->repository->getSpecificationSections($specificationId, $activeOnly);

        foreach ($sections as $section) {
            $section->sectionProdcuts = $this->specificationSectionService->getSectionProducts($section->id, $activeOnly);
        }

        return ProjectSpecificationSectionResource::collection($sections)->resolve();
    }

    /**
     * @param int $specificationId
     * @param bool $activeOnly
     * @return array
     */
    public function getSectionWithNotUsedProductsBySpecification(int $specificationId, bool $activeOnly = false): array
    {
        $specification = $this->repository->getSpecification($specificationId);
        $products = $this->projectService->getNotUsedProducts($specification->project_id, $activeOnly);

        return [
            [
                'title' => __('project.fake_section'),
                'fake_section' => true,
                'products' => ProjectSpecificationProductResource::collection($products)->resolve(),
            ]
        ];
    }

    /**
     * @param int $specificationId
     * @param array $params
     * @return BaseModel
     */
    public function addSpecificationSection(int $specificationId, array $params): BaseModel
    {
        return $this->repository->getSource()::addSection($specificationId, $params);
    }

    /**
     * @param int $specificationId
     * @param array $params
     * @return bool
     */
    public function moveProduct(int $specificationId, array $params): bool
    {
        $specification = $this->repository->getSpecification($specificationId);
        $section = $this->repository->getSpecificationSection($specificationId, $params['section']);
        $projectProduct = $this->projectService->getProjectProduct($specification->project_id, $params['product']);

        /**
         * Если к переносу передали товара больше, чем осталось не использованым, то устанавливаем сколько еще не использовано.
         */
        if ($params['amount'] > $projectProduct->pivot->not_used_amount) {
            $params['amount'] = $projectProduct->pivot->not_used_amount;
        }

        /**
         * Учитываем кол-ство товара с учетом того, которое уже есть в этой секции.
         */
        $specificationProduct = $this
            ->specificationProductService
            ->getSpecificationProductBySectionAndProduct($params['section'], $params['product']);

        if ($specificationProduct !== null) {
            $params['amount'] += $specificationProduct->amount;
        }

        if ($params['amount'] === 0) {
            return false;
        }

        return $this->repository->getSource()::addProductToSection($section, $projectProduct, $params['amount']);
    }

    /**
     * @param int $specificationId
     * @param int $projectSpecificationProductId
     * @param array $params
     * @return bool
     */
    public function updateProduct(int $specificationId, int $projectSpecificationProductId, array $params): bool
    {
        $specificationProduct = $this->specificationProductService->getSpecificationProduct($projectSpecificationProductId);
        $project = $this->projectService->getProjectBySpecificationAndSpecificationProduct($specificationId, $projectSpecificationProductId);
        $projectProduct = $this->projectService->getProjectProduct($project->id, $specificationProduct->product_id);

        /**
         * Если кол-ство пытается измениться на большее, чем осталось свободно,
         * то ставими кол-ство максимально возможное.
         */
        if (isset($params['amount'])) {
            $amountToAdd = $params['amount'] - $specificationProduct->amount;
            if ($amountToAdd > $projectProduct->pivot->not_used_amount) {
                $params['amount'] = $projectProduct->pivot->not_used_amount + $specificationProduct->amount;
            }
        }

        return $this->specificationProductService->getRepository()->getSource()::updateProduct($projectSpecificationProductId, $params);
    }

    /**
     * Пересчет спецификации
     *
     * @param int $specificationId
     * @return bool
     */
    public function reCalcSpecification(int $specificationId): bool
    {
        $project = $this->repository->getProjectBySpecification($specificationId);

        return $this->reCalcProductsInSpecification($project->products, $specificationId);
    }

    /**
     * Пересчет товаров в спецификации
     *
     * @param Collection $products
     * @param int $specificationId
     * @return bool
     */
    public function reCalcProductsInSpecification(Collection $products, int $specificationId): bool
    {
        $result = true;
        foreach ($products as $product) {
            $result = $result && $this->reCalcProductData($product->id, $specificationId);
        }

        return $result;
    }

    /**
     * Обновляет оставшееся кол-ство единиц товара. Пересчитывает цены.
     *
     * @param int $productId
     * @param int $specificationId
     * @return bool
     */
    public function reCalcProductData(int $productId, int $specificationId): bool
    {
        DB::beginTransaction();

        $result = $this->updateNotUsedProductAmount($productId, $specificationId) &&
            $this->reCalcProductPrice($productId, $specificationId);

        DB::commit();

        return $result;
    }

    /**
     * Получает кол-ство уже используемых единиц товара внутри спеки внутри всех ее разделов.
     * Спека должна быть идентична с той, которая у текущей записи товара-раздел.
     * И обновляем оставшееся кол-ство единиц товара.
     *
     * @param int $productId
     * @param int $specificationId
     * @return bool
     */
    public function updateNotUsedProductAmount(int $productId, int $specificationId): bool
    {
        $specification = $this->repository->getSpecification($specificationId);
        $usedProductAmount = $this->specificationProductService->getUsedProductAmountInSpecification($specificationId, $productId);
        $projectProduct = $this->projectService->getProjectProduct($specification->project_id, $productId);

        return $projectProduct->setNotUsedAmount($usedProductAmount);
    }

    /**
     * @param int $productId
     * @param int $specificationId
     * @return bool
     */
    public function reCalcProductPrice(int $productId, int $specificationId): bool
    {
        $specificationProducts = $this->specificationProductService->getSpecificationProductsByProduct($specificationId, $productId);

        $result = true;
        foreach ($specificationProducts as $specificationProduct) {
            $result = $result && $specificationProduct->updatePrice();
        }

        return $result;
    }

    /**
     * @param int $projectSpecificationProductId
     * @return bool
     */
    public function deleteProduct(int $projectSpecificationProductId): bool
    {
        return $this->specificationProductService->getRepository()->getSource()::deleteProduct($projectSpecificationProductId);
    }

    /**
     * @param int $specificationId
     * @param int $projectSpecificationProductId
     * @return bool
     */
    public function checkProductBelongToSpecification(int $specificationId, int $projectSpecificationProductId): bool
    {
        $specificationProduct = $this->specificationProductService->getSpecificationProduct($projectSpecificationProductId);
        $specification = $specificationProduct->specificationSection->specification;

        return $specification->id === $specificationId;
    }

    /**
     * @param int $specificationId
     * @param int $specificationSectionId
     * @return bool
     */
    public function checkSectionBelongToSpecification(int $specificationId, int $specificationSectionId): bool
    {
        $specificationSection = $this->specificationSectionService->getSection($specificationSectionId);

        $specification = $specificationSection->specification;

        return $specification->id === $specificationId;
    }

    /**
     * @param int $specificationSectionId
     * @return bool
     */
    public function deleteSection(int $specificationSectionId): bool
    {
        return $this->specificationSectionService->getRepository()->getSource()::deleteSection($specificationSectionId);
    }

    /**
     * @param int $specificationSectionId
     * @param array $params
     * @return bool
     */
    public function updateSection(int $specificationSectionId, array $params): bool
    {
        return $this->specificationSectionService->getRepository()->getSource()::updateSection($specificationSectionId, $params);
    }

    /**
     * @param int $specificationSectionId
     * @param int $specificationProductId
     * @return bool
     */
    public function checkProductBelongToSpecificationSection(int $specificationSectionId, int $specificationProductId): bool
    {
        $specificationProduct = $this->specificationProductService->getSpecificationProduct($specificationProductId);

        return $specificationProduct->project_specification_section_id === $specificationSectionId;
    }

    /**
     * @param int $specificationId
     * @param array $params
     * @return bool
     */
    public function replaceProduct(int $specificationId, array $params): bool
    {
        $specificationProduct = $this->specificationProductService->getSpecificationProduct($params['specification_product']);
        $params['amount'] = (int)$params['amount'];

        /**
         * Если кол-ство больше, чем доступно, то уставливаем доступное.
         */
        if ($params['amount'] > $specificationProduct->amount) {
            $params['amount'] = $specificationProduct->amount;
        }

        DB::beginTransaction();

        /**
         * Если перемещается все кол-ство, то удаляем из раздела источника
         */
        if ($params['amount'] === $specificationProduct->amount) {
            $this->deleteProduct($specificationProduct->id);
        } else {
            $newAmount = $specificationProduct->amount - $params['amount'];

            $this->updateProduct($specificationId, $specificationProduct->id, ['amount' => $newAmount]);
        }

        /**
         * Если в секции куда переносим уже есть такой товар, то прибавляем его текущее кол-ство к передаваемому
         */
        $sectionToSpecificationProduct = $this->specificationProductService->getSpecificationProductBySectionAndProduct($params['section_to'], $specificationProduct->product_id);
        if (!empty($sectionToSpecificationProduct)) {
            $newAmount = $sectionToSpecificationProduct->amount + $params['amount'];

            $result = $this->updateProduct($specificationId, $sectionToSpecificationProduct->id, ['amount' => $newAmount]);
        } else {
            $result = $this->moveProduct($specificationId, [
                'product' => $specificationProduct->product_id,
                'section' => $params['section_to'],
                'amount' => $params['amount'],
            ]);
        }

        DB::commit();

        return $result;
    }

    /**
     * Имитируем добавление товара в проект и перенос этого товара из не распределенной в раздел спеки.
     *
     * @param int $specificationId
     * @param int $specificationSectionId
     * @param array $params
     * @return bool
     */
    public function addProductToSpecificationSection(int $specificationId, int $specificationSectionId, array $params): bool
    {
        if (!isset($params['amount'])) {
            $params['amount'] = 1;
        }

        $specification = $this->repository->getSpecification($specificationId);

        /**
         * Формируем данные для уже существуещего метода добавление товара в проект
         */
        $paramsToAddProduct = $this->projectService->prepareProductDataToAdd($specification->project_id, $params['product'], $params['amount']);

        /**
         * Формируем данные для уже существуещего метода добавление переноса товара из не распределенной продукции
         * в определенный раздел спецификации.
         */
        $paramsToMoveProduct = [
            'product' => $params['product'],
            'section' => $specificationSectionId,
            'amount' => $params['amount'],
        ];

        DB::beginTransaction();

        $result = $this->projectService->addProductToProjects($paramsToAddProduct)
                    && $this->moveProduct($specificationId, $paramsToMoveProduct);

        DB::commit();

        return $result;
    }
}
