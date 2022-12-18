<?php

namespace App\Collections\Loyalty;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Loyalty\LoyaltyUserProposal;

/**
 * Class LoyaltyUserProposalCollection
 * @package App\Collections\Loyalty
 */
class LoyaltyUserProposalCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [LoyaltyUserProposal::class];
}
