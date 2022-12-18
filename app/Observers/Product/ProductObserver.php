<?php

namespace App\Observers\Product;

use App\Models\Product;
use App\Traits\HasCache;

/**
 * Class ProductObserver
 * @package App\Observers\Product
 */
class ProductObserver
{
    use HasCache;

    /**
     * @param Product $product
     */
    public function updated(Product $product): void
    {
        $this->clearProductsCache();
    }

    /**
     * @param Product $product
     */
    public function deleted(Product $product): void
    {
        $this->clearProductsCache();
    }
}
