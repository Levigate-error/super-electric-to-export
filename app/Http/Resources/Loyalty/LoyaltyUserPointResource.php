<?php

namespace App\Http\Resources\Loyalty;

use App\Http\Resources\BaseResource;

class LoyaltyUserPointResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'id' => $this->id,
            'points' => $this->points,
            'place' => $this->place,
            'points_gap' => $this->points_gap,
            'proposals' => LoyaltyUserProposalResource::collection($this->loyaltyUserProposals->untype())->resolve(),
        ]);
    }
}
