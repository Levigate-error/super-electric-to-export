<?php

namespace App\Domain\ServiceContracts;

/**
 * Interface ProductFeatureTypeDivisionServiceContract
 * @package App\Domain\ServiceContracts
 */
interface ProductFeatureTypeDivisionServiceContract
{
    /**
     * @param int  $id
     * @param bool $status
     *
     * @return mixed
     */
    public function publish(int $id, bool $status);
}
