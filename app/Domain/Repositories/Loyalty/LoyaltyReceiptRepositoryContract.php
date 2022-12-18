<?php

namespace App\Domain\Repositories\Loyalty;

use App\Collections\Loyalty\LoyaltyReceiptsCollection;
use App\Domain\Repositories\MustHaveGetSource;

/**
 * Interface LoyaltyReceiptRepositoryContract
 * @package App\Domain\Repositories\Loyalty
 */
interface LoyaltyReceiptRepositoryContract extends MustHaveGetSource
{
    /**
     * @param int $userId
     * @param int|null $limit
     * @return LoyaltyReceiptsCollection
     */
    public function getLoyaltyReceiptsByUserId(int $userId, ?int $limit = null): LoyaltyReceiptsCollection;

    /**
     * @param int $userId
     * @return float
     */
    public function getLoyaltyReceiptsTotalAmountByUserId(int $userId): float;
}
