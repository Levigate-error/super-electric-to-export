<?php

namespace App\Repositories\Loyalty;

use App\Models\Loyalty\LoyaltyUserProposal;
use App\Domain\Repositories\Loyalty\LoyaltyUserProposalRepositoryContract;
use App\Repositories\BaseRepository;

/**
 * Class LoyaltyUserProposalRepository
 * @package App\Repositories\Loyalty
 */
class LoyaltyUserProposalRepository extends BaseRepository implements LoyaltyUserProposalRepositoryContract
{
    /**
     * @var string
     */
    protected $source = LoyaltyUserProposal::class;

    /**
     * @param  string  $code
     * @return LoyaltyUserProposal|null
     */
    public function getProposalByProductCode(string $code): ?LoyaltyUserProposal
    {
        return $this->getQueryBuilder()
            ->where('code', $code)
            ->first();
    }

    /**
     * @param int $id
     * @return LoyaltyUserProposal|null
     */

    public function getProposalById(int $id): ?LoyaltyUserProposal
     {
         return $this->getQueryBuilder()
            ->where('id', $id)
            ->first();
     }
}
