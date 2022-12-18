<?php

namespace App\Domain\ServiceContracts;

/**
 * Interface ProductDivisionServiceContract
 * @package App\Domain\ServiceContracts
 */
interface ProductDivisionServiceContract
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
