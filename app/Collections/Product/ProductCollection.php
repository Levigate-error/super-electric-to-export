<?php

namespace App\Collections\Product;

use Gamez\Illuminate\Support\TypedCollection;
use App\Models\Product;

/**
 * Class ProductCollection
 * @package App\Collections\Product
 */
class ProductCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [Product::class];
}
