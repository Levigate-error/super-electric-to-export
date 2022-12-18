<?php

namespace App\Domain\ServiceContracts;

/**
 * Interface ProductCategoryServiceContract
 * @package App\Domain\ServicesContracts
 */
interface ProductCategoryServiceContract
{
    /**
     * @return mixed
     */
    public function getList();

    /**
     * @param int  $id
     * @param bool $status
     *
     * @return mixed
     */
    public function publish(int $id, bool $status);

    /**
     * @return mixed
     */
    public function getToMainPage();
}
