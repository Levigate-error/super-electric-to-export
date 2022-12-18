<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Loyalty\LoyaltyReceipt;
use App\Mail\LoyaltyReceiptAdmin as Mailable;

/**
 * Class LoyaltyReceiptAdminNotification
 * @package App\Notifications
 */
class LoyaltyReceiptAdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $tries = 3;

    /**
     * @param LoyaltyReceipt $loyaltyUser
     * @return array
     */
    public function via(LoyaltyReceipt $loyalityReceipt): array
    {
        if (empty($loyalityReceipt->getNotificationTransports()) === false) {
            return $loyalityReceipt->getNotificationTransports();
        }

        return ['mail'];
    }

    /**
     * @param LoyaltyReceipt $loyaltyUser
     * @return Mailable
     */
    public function toMail(LoyaltyReceipt $loyalityReceipt)
    {
        return (new Mailable($loyalityReceipt));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
