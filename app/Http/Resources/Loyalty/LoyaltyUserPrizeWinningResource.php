<?php

namespace App\Http\Resources\Loyalty;

use App\Domain\Dictionaries\Loyalty\LoyaltyUserPrizeWinningStatuses;
use Illuminate\Http\Resources\Json\JsonResource;

class LoyaltyUserPrizeWinningResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'status_for_human' => LoyaltyUserPrizeWinningStatuses::toHuman($this->status)
        ]);
    }
}
