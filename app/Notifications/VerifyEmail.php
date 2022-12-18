<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use App\Mail\UserEmailVerification as Mailable;

/**
 * Class VerifyEmail
 * @package App\Notifications
 */
class VerifyEmail extends BaseVerifyEmail implements ShouldQueue
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
        return (new Mailable($user));
    }
}
