<?php

namespace App\Http\Resources\Loyalty;

use App\Http\Resources\BaseResource;
use App\Http\Resources\CertificateResource;

/**
 * Class LoyaltyUserResource
 * @package App\Http\Resources\Loyalty
 */
class LoyaltyUserResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'id' => $this->id,
            'status' => $this->status,
            'loyalty' => LoyaltyResource::make($this->loyalty)->resolve(),
            'certificate' => $this->certificate 
                ? CertificateResource::make($this->certificate)->resolve()
                : null,
            'loyalty_points' => LoyaltyUserPointResource::make($this->loyaltyUserPoint)->resolve(),
            'loyalty_category' => ($this->loyaltyUserCategory !== null)
                ? LoyaltyUserCategoryResource::make($this->loyaltyUserCategory)->resolve()
                : null,
            'loyalty_user_winnings' => LoyaltyUserPrizeWinningResource::collection($this->loyaltyUserWinnings),
        ]);
    }
}
