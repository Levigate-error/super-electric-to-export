<?php

namespace App\Services;

use App\Domain\ServiceContracts\ProductFeatureTypeDivisionServiceContract;
use App\Domain\Repositories\ProductFeatureTypeDivisionRepository;

/**
 * Class ProductFeatureTypeDivisionService
 * @package App\Services
 */
class ProductFeatureTypeDivisionService extends BaseService implements ProductFeatureTypeDivisionServiceContract
{
    /**
     * @var ProductFeatureTypeDivisionRepository
     */
    private $repository;

    /**
     * ProductFeatureTypeDivisionService constructor.
     *
     * @param ProductFeatureTypeDivisionRepository $repository
     */
    public function __construct(ProductFeatureTypeDivisionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int  $id
     * @param bool $status
     *
     * @return mixed
     */
    public function publish(int $id, bool $status)
    {
        $source = $this->repository->getSource();

        $this->clearCache();

        return $source::publish($id, $status);
    }
}
