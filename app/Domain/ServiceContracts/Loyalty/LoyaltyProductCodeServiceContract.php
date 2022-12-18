<?php

namespace App\Domain\ServiceContracts\Loyalty;

use App\Domain\Repositories\Loyalty\LoyaltyProductCodeRepositoryContract;
use App\Http\Resources\Loyalty\LoyaltyProductCodeResource;

/**
 * Interface LoyaltyProductCodeServiceContract
 * @package App\Domain\ServiceContracts\Loyalty
 */
interface LoyaltyProductCodeServiceContract
{
    /**
     * @return LoyaltyProductCodeRepositoryContract
     */
    public function getRepository(): LoyaltyProductCodeRepositoryContract;

    /**
     * @param array $params
     * @return LoyaltyProductCodeResource
     */
    public function createProductCode(array $params = []): LoyaltyProductCodeResource;

    /**
     * @param string $code
     * @return LoyaltyProductCodeResource
     */
    public function getProductCodeByCode(string $code): LoyaltyProductCodeResource;

    /**
     * @param string $code
     * @return bool
     */
    public function checkProductCode(string $code): bool;
}
