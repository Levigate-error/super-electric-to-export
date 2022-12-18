<?php

namespace App\Domain\ServiceContracts\Loyalty;

use App\Domain\Repositories\Loyalty\LoyaltyProductCodeRepositoryContract;
use App\Http\Resources\Loyalty\LoyaltyReceiptResource;
use App\Domain\Repositories\Loyalty\LoyaltyReceiptRepositoryContract;

/**
 * Interface LoyaltyReceiptServiceContract
 * @package App\Domain\ServiceContracts\Loyalty
 */
interface LoyaltyReceiptServiceContract
{
    /**
     * @param array $params
     * @return LoyaltyReceiptResource
     */
    public function uploadReceipt(array $params = []): LoyaltyReceiptResource;

    /**
     * @param array $params
     * @return LoyaltyReceiptResource
     */
    public function uploadReceiptManually(array $params = []): LoyaltyReceiptResource;

    /**
     * @return LoyaltyProductCodeRepositoryContract
     */
    public function getRepository(): LoyaltyReceiptRepositoryContract;

    /**
     * @return array
     */
    public function getLoyaltyReceiptsByUser(): array;

    /**
     * @return float
     */
    public function getLoyaltyReceiptsTotalAmountByUser(): float;
}
