<?php

namespace App\Domain\ServiceContracts\Loyalty;

use App\Collections\Loyalty\LoyaltyUserProposalCollection;
use App\Domain\Repositories\Loyalty\LoyaltyUserProposalRepositoryContract;
use App\Http\Resources\Loyalty\LoyaltyUserProposalResource;

/**
 * Interface LoyaltyUserProposalServiceContract
 * @package App\Domain\ServiceContracts\Loyalty
 */
interface LoyaltyUserProposalServiceContract
{
    /**
     * @return LoyaltyUserProposalRepositoryContract
     */
    public function getRepository(): LoyaltyUserProposalRepositoryContract;

    /**
     * @param  int  $userPointId
     * @param  string  $code
     * @return LoyaltyUserProposalResource
     */
    public function registerProposal(int $userPointId, string $code): LoyaltyUserProposalResource;

    /**
     * @param LoyaltyUserProposalCollection $proposals
     * @return int
     */
    public function getProposalsPoints(LoyaltyUserProposalCollection $proposals): int;

    /**
     * @param  string  $code
     * @return bool
     */
    public function checkProductCodeUsage(string $code): bool;
}
