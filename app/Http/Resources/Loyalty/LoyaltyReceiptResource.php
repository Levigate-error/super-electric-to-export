<?php

namespace App\Http\Resources\Loyalty;

use App\Domain\Dictionaries\Loyalty\LoyaltyReceiptsReviewStatuses;
use App\Domain\Dictionaries\Loyalty\LoyaltyReceiptsStatuses;
use App\Http\Resources\BaseResource;
use Illuminate\Support\Carbon;

/**
 * Class LoyaltyReceiptResource
 * @package App\Http\Resources\Loyalty
 */
class LoyaltyReceiptResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'fn' => $this->fn,
            'points_already_accured' => $this->points_already_accured,
            'created_at' => $this->created_at->format('d.m.Y'),
            'receipt_datetime' => $this->receipt_datetime 
                ? Carbon::createFromFormat('Y-m-d H:i:s', $this->receipt_datetime)->format('d.m.Y')
                : null,
            'review_status' => LoyaltyReceiptsReviewStatuses::getToHumanResource()[$this->review_status_id],
            'lottery_id' => $this->lottery_id,
            'coupon_code' => $this->coupon_code,
        ]);
    }
}
