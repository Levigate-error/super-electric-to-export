<?php

namespace App\Repositories\Project;

use App\Models\BaseModel;
use App\Models\Project\ProjectSpecificationProduct;
use App\Domain\Repositories\Project\ProjectSpecificationProductRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use App\Traits\HasSourceGetter;
use App\Repositories\BaseRepository;

/**
 * Class ProjectSpecificationProductEloquentRepository
 * @package App\Repositories\Project
 */
class ProjectSpecificationProductEloquentRepository extends BaseRepository implements
    ProjectSpecificationProductRepository
{
    use HasSourceGetter;

    /**
     * @var string
     */
    private $source = ProjectSpecificationProduct::class;

    /**
     * @param int $specificationProductId
     * @return BaseModel
     */
    public function getSpecificationProduct(int $specificationProductId): BaseModel
    {
        return $this->getSource()::query()->findOrFail($specificationProductId);
    }

    /**
     * @param int $specificationId
     * @param int $productId
     * @return int
     */
    public function getUsedProductAmountInSpecification(int $specificationId, int $productId): int
    {
        return $this->getSource()::query()
            ->where(['product_id' => $productId])
            ->whereHas(
                'specificationSection',
                static function (Builder $sectionBuilder) use ($specificationId) {
                    $sectionBuilder->where(['project_specification_id' => $specificationId]);

                    return $sectionBuilder;
                }
            )->sum('amount');
    }

    /**
     * @param int $specificationId
     * @param int $productId
     * @return Collection
     */
    public function getSpecificationProductsByProduct(int $specificationId, int $productId): Collection
    {
        return $this->getSource()::query()
            ->where(['product_id' => $productId])
            ->whereHas(
                'specificationSection',
                static function (Builder $sectionBuilder) use ($specificationId) {
                    $sectionBuilder->where(['project_specification_id' => $specificationId]);

                    return $sectionBuilder;
                }
            )->get();
    }

    /**
     * @param $sectionId
     * @param $productId
     * @return BaseModel|null
     */
    public function getSpecificationProductBySectionAndProduct($sectionId, $productId): ?BaseModel
    {
        return $this->getSource()::query()
            ->where(
                [
                    'product_id' => $productId,
                    'project_specification_section_id' => $sectionId,
                ]
            )->first();
    }

    /**
     * @param int $projectId
     * @param int $specificationId
     * @return Collection
     */
    public function getProjectSpecificationProducts(int $projectId, int $specificationId): Collection
    {
        return $this->getQueryBuilder()
            ->select('project_specification_products.*')
            ->leftJoin(
                'project_products',
                'project_products.id',
                '=',
                'project_specification_products.project_product_id'
            )->leftJoin(
                'project_specification_sections',
                'project_specification_sections.id',
                '=',
                'project_specification_products.project_specification_section_id'
            )
            ->where(
                [
                    'project_products.project_id' => $projectId,
                    'project_specification_sections.project_specification_id' => $specificationId,
                ]
            )->get();
    }
}
