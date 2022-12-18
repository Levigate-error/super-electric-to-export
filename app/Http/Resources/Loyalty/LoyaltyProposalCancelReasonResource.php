<?php

namespace App\Http\Resources\Loyalty;

use App\Http\Resources\BaseResource;

/**
 * Class LoyaltyProposalCancelReasonResource
 * @package App\Http\Resources\Loyalty
 */
class LoyaltyProposalCancelReasonResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'id' => $this->id,
            'value' => $this->value,
        ]);
    }
}
