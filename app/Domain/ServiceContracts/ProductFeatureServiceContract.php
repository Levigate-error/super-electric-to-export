<?php

namespace App\Domain\ServiceContracts;

/**
 * Interface ProductFeatureServiceContract
 * @package App\Domain\ServiceContracts
 */
interface ProductFeatureServiceContract
{
    /**
     * @param array $params
     *
     * @return mixed
     */
    public function getFiltersByParams(array $params = []);
}
