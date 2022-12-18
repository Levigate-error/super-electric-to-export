<?php

namespace App\Traits;

use App\Domain\Dictionaries\Cache\ProductCache;
use App\Domain\Dictionaries\Cache\ProductCategoryCache;
use App\Domain\Dictionaries\Cache\ProductDivisionCache;
use App\Domain\Dictionaries\Cache\ProductFamilyCache;
use App\Domain\Dictionaries\Cache\ProductFeatureCache;
use Illuminate\Support\Facades\Cache;

/**
 * Trait HasCache
 * @package App\Traits
 */
trait HasCache
{
    protected function clearCache(): void
    {
        Cache::forget(ProductCategoryCache::LIST);
        Cache::tags(ProductDivisionCache::LIST)->flush();
        Cache::tags(ProductFamilyCache::LIST)->flush();
        Cache::tags(ProductCache::LIST)->flush();
        Cache::tags(ProductCache::DETAILS)->flush();
        Cache::tags(ProductCache::RECOMMENDED)->flush();
        Cache::tags(ProductFeatureCache::LIST)->flush();
    }

    protected function clearProductsCache(): void
    {
        Cache::tags(ProductCache::LIST)->flush();
        Cache::tags(ProductCache::DETAILS)->flush();
        Cache::tags(ProductCache::RECOMMENDED)->flush();
    }

    /**
     * @param $params
     * @return string
     */
    protected function generateCacheHash($params): string
    {
        return hash('sha256', serialize($params));
    }
}
