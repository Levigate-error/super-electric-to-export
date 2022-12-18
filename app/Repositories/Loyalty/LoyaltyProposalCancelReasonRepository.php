<?php

namespace App\Repositories\Loyalty;

use App\Models\Loyalty\LoyaltyProposalCancelReason;
use App\Domain\Repositories\Loyalty\LoyaltyProposalCancelReasonRepositoryContract;
use App\Repositories\BaseRepository;

/**
 * Class LoyaltyProposalCancelReasonRepository
 * @package App\Repositories\Loyalty
 */
class LoyaltyProposalCancelReasonRepository extends BaseRepository implements LoyaltyProposalCancelReasonRepositoryContract
{
    /**
     * @var string
     */
    protected $source = LoyaltyProposalCancelReason::class;
}
