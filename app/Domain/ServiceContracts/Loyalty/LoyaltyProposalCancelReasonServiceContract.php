<?php

namespace App\Domain\ServiceContracts\Loyalty;

use App\Domain\Repositories\Loyalty\LoyaltyProposalCancelReasonRepositoryContract;
use App\Http\Resources\Loyalty\LoyaltyProposalCancelReasonResource;

/**
 * Interface LoyaltyProposalCancelReasonServiceContract
 * @package App\Domain\ServiceContracts\Loyalty
 */
interface LoyaltyProposalCancelReasonServiceContract
{
    /**
     * @return LoyaltyProposalCancelReasonRepositoryContract
     */
    public function getRepository(): LoyaltyProposalCancelReasonRepositoryContract;

    /**
     * @param array $params
     * @return LoyaltyProposalCancelReasonResource
     */
    public function createProposalCancelReason(array $params = []): LoyaltyProposalCancelReasonResource;
}
