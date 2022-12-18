<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as BaseResetPasswordNotification;
use App\Mail\ResetPassword as Mailable;

/**
 * Class ResetPasswordNotification
 * @package App\Notifications
 */
class ResetPasswordNotification extends BaseResetPasswordNotification implements ShouldQueue
{
    use Queueable;

    /**
     * @param mixed $user
     * @return array
     */
    public function via($user): array
    {
        if (empty($user->getNotificationTransports()) === false) {
            return $user->getNotificationTransports();
        }

        return ['mail'];
    }

    /**
     * @param mixed $user
     * @return Mailable|MailMessage
     */
    public function toMail($user)
    {
        return (new Mailable($user, $this->token));
    }
}
