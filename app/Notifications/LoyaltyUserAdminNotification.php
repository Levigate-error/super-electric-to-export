<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Loyalty\LoyaltyUser;
use App\Mail\LoyaltyUserAdmin as Mailable;

/**
 * Class LoyaltyUserAdminNotification
 * @package App\Notifications
 */
class LoyaltyUserAdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @param LoyaltyUser $loyaltyUser
     * @return array
     */
    public function via(LoyaltyUser $loyaltyUser): array
    {
        if (empty($loyaltyUser->getNotificationTransports()) === false) {
            return $loyaltyUser->getNotificationTransports();
        }

        return ['mail'];
    }

    /**
     * @param LoyaltyUser $loyaltyUser
     * @return Mailable
     */
    public function toMail(LoyaltyUser $loyaltyUser)
    {
        return (new Mailable($loyaltyUser));
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
