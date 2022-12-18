<?php

namespace App\Domain\ServiceContracts;

/**
 * Interface ProductFamilyServiceContract
 * @package App\Domain\ServiceContracts
 */
interface ProductFamilyServiceContract
{
    /**
     * @param array $params
     *
     * @return mixed
     */
    public function getListByParams(array $params);

    /**
     * @param int  $id
     * @param bool $status
     *
     * @return mixed
     */
    public function publish(int $id, bool $status);
}
