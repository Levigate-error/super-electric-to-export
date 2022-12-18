<?php

namespace App\Domain\Repositories\Loyalty;

use App\Collections\Loyalty\LoyaltyCollection;
use App\Domain\Repositories\MustHaveGetSource;

/**
 * Interface LoyaltyRepositoryContract
 * @package App\Domain\Repositories\Loyalty
 */
interface LoyaltyRepositoryContract extends MustHaveGetSource
{
    /**
     * @param array $params
     * @return LoyaltyCollection
     */
    public function getLoyaltyList(array $params = []): LoyaltyCollection;

    public function getLoyaltyIdByTitle(string $title): ?int;
}
