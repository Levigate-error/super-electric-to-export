<?php

namespace App\Observers\Loyalty;

use App\Models\Loyalty\LoyaltyReceipt;
use App\Domain\Dictionaries\Loyalty\LoyaltyReceiptsStatuses;
use App\Notifications\LoyaltyReceiptAdminNotification;
use App\Traits\Notificationable;

class LoyaltyReceiptObserver
{
    use Notificationable;

    /**
     * Handle the loyality receipt "updating" event.
     *
     * @param  App\Models\Loyalty\LoyaltyReceipt  $loyalityReceipt
     * @return void
     */
    public function updating(LoyaltyReceipt $loyalityReceipt)
    {
        $loyalityReceipt->points_already_accured += $loyalityReceipt->getOriginal('points_already_accured');
        //$loyalityReceipt->status_id = LoyaltyReceiptsStatuses::PROCESSED;
    }

    /**
     * Handle the loyality receipt "saved" event.
     *
     * @param  App\Models\Loyalty\LoyaltyReceipt  $loyalityReceipt
     * @return void
     */
    public function saved(LoyaltyReceipt $loyalityReceipt)
    {
        $loyaltyUserPoints = $loyalityReceipt->loyaltyUserPoints()->firstOrNew(['loyalty_user_id' => $loyalityReceipt->loyalty_user_id]);
        $loyaltyUserPoints->points += $loyalityReceipt->points_already_accured;
        $loyaltyUserPoints->save();

        $loyalityReceipt->notify(new LoyaltyReceiptAdminNotification());
    }

    /**
     * @param LoyaltyReceipt $loyalityReceipt
     */
    public function created(LoyaltyReceipt $loyalityReceipt): void
    {
        $loyalityReceipt->notify(new LoyaltyReceiptAdminNotification());
    }
}
