<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use App\Mail\LoyaltyUserCanceled;

/**
 * Class LoyaltyUserCanceledNotification
 * @package App\Notifications
 */
class LoyaltyUserCanceledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @param User $user
     * @return array
     */
    public function via(User $user): array
    {
        if (empty($user->getNotificationTransports()) === false) {
            return $user->getNotificationTransports();
        }

        return ['mail'];
    }

    /**
     * @param User $user
     * @return LoyaltyUserCanceled
     */
    public function toMail(User $user): LoyaltyUserCanceled
    {
        return (new LoyaltyUserCanceled($user));
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
