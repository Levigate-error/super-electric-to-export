<?php

namespace App\Domain\Repositories\Loyalty;

use App\Domain\Repositories\MustHaveGetSource;
use App\Models\Loyalty\LoyaltyUserProposal;

/**
 * Interface LoyaltyUserProposalRepositoryContract
 * @package App\Domain\Repositories\Loyalty
 */
interface LoyaltyUserProposalRepositoryContract extends MustHaveGetSource
{
    /**
     * @param  string  $code
     * @return LoyaltyUserProposal|null
     */
    public function getProposalByProductCode(string $code): ?LoyaltyUserProposal;

    /**
     * @param int $id
     * @return LoyaltyUserProposal|null
     */
    public function getProposalById(int $id): ?LoyaltyUserProposal;
}
