<?php

namespace App\Traits;

use App\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Trait ProjectSpecificationServiceGetter
 * @package App\Traits
 */
trait ServiceGetter
{
    /**
     * @param string $class
     * @return BaseService
     * @throws BindingResolutionException
     */
    public function getService(string $class): BaseService
    {
        return app()->make($class);
    }
}
