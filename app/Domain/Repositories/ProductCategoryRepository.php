<?php

namespace App\Domain\Repositories;

use Illuminate\Support\Collection;

/**
 * Interface ProductCategoryRepository
 * @package App\Domain\Repositories
 */
interface ProductCategoryRepository extends MustHaveGetSource
{
    /**
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * @return Collection
     */
    public function getToMainPage(): Collection;

    /**
     * @param int $productCategoryId
     * @return Collection
     */
    public function getDivisions(int $productCategoryId): Collection;
}
