<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use App\Mail\LoyaltyUserProposal as Mailable;

/**
 * Class LoyaltyUserProposalNotification
 * @package App\Notifications
 */
class LoyaltyUserProposalNotification extends Notification implements ShouldQueue
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
     * @return Mailable
     */
    public function toMail(User $user)
    {
        return (new Mailable($user));
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
