<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Loyalty\LoyaltyUserProposal;
use App\Mail\LoyaltyUserProposalAdmin as Mailable;

/**
 * Class LoyaltyUserProposalAdminNotification
 * @package App\Notifications
 */
class LoyaltyUserProposalAdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @param LoyaltyUserProposal $userProposal
     * @return array
     */
    public function via(LoyaltyUserProposal $userProposal): array
    {
        if (empty($userProposal->getNotificationTransports()) === false) {
            return $userProposal->getNotificationTransports();
        }

        return ['mail'];
    }

    /**
     * @param LoyaltyUserProposal $userProposal
     * @return Mailable
     */
    public function toMail(LoyaltyUserProposal $userProposal)
    {
        return (new Mailable($userProposal));
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
