<?php

namespace App\Repositories\Project;

use App\Repositories\BaseRepository;
use App\Models\Project\Project;
use App\Models\BaseModel;
use App\Domain\Repositories\Project\ProjectRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use App\Collections\ProjectCollection;
use App\Collections\Product\ProductCollection;

/**
 * Class ProjectEloquentRepository
 * @package App\Repositories\Project
 */
class ProjectEloquentRepository extends BaseRepository implements ProjectRepository
{
    /**
     * @var string
     */
    protected $source = Project::class;

    /**
     * @param int $projectId
     * @return mixed
     */
    public function getProjectDetails(int $projectId)
    {
        return $this->getSource()::query()->findOrFail($projectId);
    }

    /**
     * @param int $limit
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function getProjectsByParams(int $limit = 15, array $params = []): LengthAwarePaginator
    {
        $query = $this->getSource()::query()
            ->where($params)
            ->orderBy('projects.updated_at', 'desc');

        $limit = $this->prepareLimit($limit);

        return $query->paginate($limit);
    }

    /**
     * @param int $projectId
     * @return Collection
     */
    public function getProjectCategories(int $projectId): Collection
    {
        $project = $this->getProjectDetails($projectId);

        return $project->productCategories;
    }

    /**
     * @param int $projectId
     * @param int $productDivisionId
     * @return int
     */
    public function getProductAmountInDivision(int $projectId, int $productDivisionId): int
    {
        $project = $this->getProjectDetails($projectId);

        return $project->products()->where(['division_id' => $productDivisionId])->sum('project_products.amount');
    }

    /**
     * @param int $projectId
     * @param int $productDivisionId
     * @return Collection
     */
    public function getProjectAndDivisionProducts(int $projectId, int $productDivisionId): Collection
    {
        $project = $this->getProjectDetails($projectId);

        return $project->products()->where(['division_id' => $productDivisionId])->get();
    }

    /**
     * @param int $projectId
     * @param array $params
     * @return Collection
     */
    public function getProjectProductsByParams(int $projectId, array $params = []): Collection
    {
        $project = $this->getProjectDetails($projectId);
        $project = $project->products()->select(
            [
                'products.*',
                'project_products.real_price',
                'project_products.active',
                'project_products.in_stock',
                'project_products.discount',
                'project_products.price_with_discount',
            ]
        );

        if (isset($params['active']) && $params['active']) {
            $project = $project->activeProducts();
        }

        if (isset($params['search'])) {
            $locale = get_current_local();

            $project = $project->where(
                static function ($query) use ($params, $locale) {
                    $query->orWhere("products.name->" . $locale, 'ILIKE', '%' . $params['search'] . '%');
                    $query->orWhere('products.recommended_retail_price', '=', (float)$params['search']);

                    $query->orWhereHas(
                        'featureTypesValues',
                        static function (Builder $builder) use ($params, $locale) {
                            $builder->whereHas(
                                'value',
                                static function (Builder $valueBuilder) use ($params, $locale) {
                                    $valueBuilder->where(
                                        'product_feature_values.value->' . $locale,
                                        'ILIKE',
                                        '%' . $params['search'] . '%'
                                    );

                                    return $valueBuilder;
                                }
                            );
                        }
                    );

                    $query->orWhereHas(
                        'family',
                        static function (Builder $builder) use ($params, $locale) {
                            $builder->where(
                                'product_families.name->' . $locale,
                                'ILIKE',
                                '%' . $params['search'] . '%'
                            );
                        }
                    );
                }
            );
        }

        return $project->get();
    }

    /**
     * @param int $projectId
     * @return BaseModel|null
     */
    public function getProjectSpecifications(int $projectId): ?BaseModel
    {
        $project = $this->getProjectDetails($projectId);

        return $project->specification();
    }

    /**
     * @param int $projectId
     * @param bool $activeOnly
     * @return Collection
     */
    public function getNotUsedProducts(int $projectId, bool $activeOnly = false): Collection
    {
        $project = $this->getProjectDetails($projectId);

        if ($activeOnly) {
            return $project->products()
                ->activeProducts()
                ->where('not_used_amount', '>', 0)
                ->get();
        }

        return $project->products()->where('not_used_amount', '>', 0)->get();
    }

    /**
     * @param int $projectId
     * @param int $productId
     * @param bool $withException
     * @return BaseModel|null
     */
    public function getProjectProduct(int $projectId, int $productId, bool $withException = true): ?BaseModel
    {
        $project = $this->getProjectDetails($projectId);
        $project = $project->products()->where(['product_id' => $productId]);

        if ($withException) {
            return $project->firstOrFail();
        }

        return $project->first();
    }

    /**
     * @param int $specificationId
     * @param int $specificationProductId
     * @return BaseModel
     */
    public function getProjectBySpecificationAndSpecificationProduct(
        int $specificationId,
        int $specificationProductId
    ): BaseModel {
        return $this->getSource()::query()
            ->whereHas(
                'specifications',
                static function (Builder $specificationBuilder) use ($specificationId, $specificationProductId) {
                    $specificationBuilder
                        ->where(['id' => $specificationId])
                        ->whereHas(
                            'specificationSections',
                            static function (Builder $sectionBuilder) use ($specificationProductId) {
                                $sectionBuilder
                                    ->whereHas(
                                        'products',
                                        static function (Builder $productBuilder) use ($specificationProductId) {
                                            $productBuilder->where(['id' => $specificationProductId]);

                                            return $productBuilder;
                                        }
                                    );

                                return $sectionBuilder;
                            }
                        );

                    return $specificationBuilder;
                }
            )->firstOrFail();
    }

    /**
     * @param int $projectId
     * @param int $productId
     * @return int
     */
    public function getProjectProductUsedAmount(int $projectId, int $productId): int
    {
        $projectProduct = $this->getProjectProduct($projectId, $productId);

        return (int)($projectProduct->pivot->amount - $projectProduct->pivot->not_used_amount);
    }

    /**
     * @param string $session
     * @return ProjectCollection
     */
    public function getProjectsBySession(string $session): ProjectCollection
    {
        $projects = $this->getQueryBuilder()->where(['session_key' => $session])->get()->all();

        return new ProjectCollection($projects);
    }

    /**
     * @param int $projectId
     * @param int $categoryId
     * @return ProductCollection
     */
    public function getProjectAndCategoryProducts(int $projectId, int $categoryId): ProductCollection
    {
        $project = $this->getProjectDetails($projectId);
        $products = $project->products()->where(['category_id' => $categoryId]);

        /**
         * TODO
         *
         * Пока так. Потому что стремно прям в модели товаров указывать коллекцию. Боюсь что-то отвалиться.
         * Будет свободное время поменять в модели и протестить.
         */
        return ProductCollection::make($products->get());
    }
}
