<?php

namespace App\Repositories;

use App\Models\ProductCategory;
use App\Domain\Repositories\ProductCategoryRepository;
use Illuminate\Support\Collection;
use App\Traits\HasSourceGetter;

/**
 * Class ProductCategoryService
 * @package App\Services
 */
class ProductCategoryEloquentRepository implements ProductCategoryRepository
{
    use HasSourceGetter;

    /**
     * @var string
     */
    private $source = ProductCategory::class;

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->getSource()::published()->orderBy('id', 'asc')->get();
    }

    /**
     * @return Collection
     */
    public function getToMainPage(): Collection
    {
        return $this->getSource()::published()->toMain()->get();
    }

    /**
     * @param int $productCategoryId
     * @return Collection
     */
    public function getDivisions(int $productCategoryId): Collection
    {
        $category = $this->getSource()::query()->findOrFail($productCategoryId);

        return $category->divisions()
                    ->select(['product_divisions.*'])
                    ->published()
                    ->orderBy('product_divisions.id', 'asc')
                    ->get();
    }
}
