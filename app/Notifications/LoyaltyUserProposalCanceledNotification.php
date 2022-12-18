<?php

namespace App\Notifications;

use App\Models\Loyalty\LoyaltyUserProposal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use App\Mail\LoyaltyUserProposalCanceled;

/**
 * Class LoyaltyUserProposalCanceledNotification
 * @package App\Notifications
 */
class LoyaltyUserProposalCanceledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var LoyaltyUserProposal
     */
    protected $proposal;

    /**
     * LoyaltyUserProposalCanceledNotification constructor.
     * @param LoyaltyUserProposal $proposal
     */
    public function __construct(LoyaltyUserProposal $proposal)
    {
        $this->proposal = $proposal;
    }

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
     * @return LoyaltyUserProposalCanceled
     */
    public function toMail(User $user): LoyaltyUserProposalCanceled
    {
        return (new LoyaltyUserProposalCanceled($user, $this->proposal));
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
