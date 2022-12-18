<?php

namespace App\Observers\Product;

use App\Models\ProductCategory;
use App\Traits\HasCache;

/**
 * Class ProductCategoryObserver
 * @package App\Observers\Product
 */
class ProductCategoryObserver
{
    use HasCache;

    /**
     * @param ProductCategory $product
     */
    public function updated(ProductCategory $product): void
    {
        $this->clearCache();
    }

    /**
     * @param ProductCategory $product
     */
    public function deleted(ProductCategory $product): void
    {
        $this->clearCache();
    }
}
