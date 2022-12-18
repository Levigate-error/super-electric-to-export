<?php

namespace App\Services\Loyalty;

use App\Services\BaseService;
use App\Domain\ServiceContracts\Loyalty\LoyaltyProductCodeServiceContract;
use App\Domain\Repositories\Loyalty\LoyaltyProductCodeRepositoryContract;
use App\Http\Resources\Loyalty\LoyaltyProductCodeResource;

/**
 * Class LoyaltyProductCodeService
 * @package App\Services\Loyalty
 */
class LoyaltyProductCodeService extends BaseService implements LoyaltyProductCodeServiceContract
{
    /**
     * @var LoyaltyProductCodeRepositoryContract
     */
    private $repository;

    /**
     * LoyaltyProductCodeService constructor.
     * @param LoyaltyProductCodeRepositoryContract $repository
     */
    public function __construct(LoyaltyProductCodeRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return LoyaltyProductCodeRepositoryContract
     */
    public function getRepository(): LoyaltyProductCodeRepositoryContract
    {
        return $this->repository;
    }

    /**
     * @param array $params
     * @return LoyaltyProductCodeResource
     */
    public function createProductCode(array $params = []): LoyaltyProductCodeResource
    {
        $productCode = $this->repository->getSource()::create($params);

        return LoyaltyProductCodeResource::make($productCode);
    }

    /**
     * @param string $code
     * @return LoyaltyProductCodeResource
     */
    public function getProductCodeByCode(string $code): LoyaltyProductCodeResource
    {
        $certificate = $this->repository->getProductCodeByCode($code);

        return LoyaltyProductCodeResource::make($certificate);
    }

    /**
     * @param string $code
     * @return bool
     */
    public function checkProductCode(string $code): bool
    {
        $productCode = $this->getProductCodeByCode($code);

        if ($productCode->resource === null) {
            return false;
        }

        if ($productCode->resource->active === false) {
            return false;
        }

        return true;
    }
}
