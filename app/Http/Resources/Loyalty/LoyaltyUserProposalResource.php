<?php

namespace App\Http\Resources\Loyalty;

use App\Http\Resources\BaseResource;

/**
 * Class LoyaltyUserProposalResource
 * @package App\Http\Resources\Loyalty
 */
class LoyaltyUserProposalResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'id' => $this->id,
            'status' => $this->proposal_status,
            'status_on_human' => $this->statusOnHuman,
            'points' => $this->points,
            'accrued_points' => $this->accrue_points,
            'created_at' => $this->created_at->format('d-m-Y'),
            'code' => ($this->loyaltyProductCode !== null)
                ? LoyaltyProductCodeResource::make($this->loyaltyProductCode)->resolve()
                : null,
            'cancel_reason' => ($this->loyaltyCancelReason !== null)
                ? LoyaltyProposalCancelReasonResource::make($this->loyaltyCancelReason)->resolve()
                : null,
            'code_text' => $this->code,
        ]);
    }
}
