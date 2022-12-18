<?php

namespace App\Domain\ServiceContracts\Loyalty;

use App\Domain\Repositories\Loyalty\LoyaltyRepositoryContract;

/**
 * Interface LoyaltyServiceContract
 * @package App\Domain\ServiceContracts\Loyalty
 */
interface LoyaltyServiceContract
{
    /**
     * @return LoyaltyRepositoryContract
     */
    public function getRepository(): LoyaltyRepositoryContract;

    /**
     * @param array $params
     * @return array
     */
    public function createLoyalty(array $params = []): array;

    /**
     * @param array $params
     * @return array
     */
    public function getLoyaltyList(array $params = []): array;

    /**
     * @param  array  $params
     * @return array
     */
    public function registerUser(array $params): array;

    /**
     * @param array $params
     * @return array
     */
    public function registerProductCode(array $params): array;

    /**
     * @param array $params
     * @return array
     */
    public function uploadReceipt(array $params): array;

    /**
     * @param int $loyaltyId
     * @return array
     */
    public function getCurrentUserProposalsList(int $loyaltyId): array;
}
