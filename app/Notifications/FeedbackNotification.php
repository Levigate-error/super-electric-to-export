<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Feedback;
use App\Mail\Feedback as Mailable;

class FeedbackNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @param Feedback $feedback
     * @return array
     */
    public function via(Feedback $feedback): array
    {
        if (empty($feedback->getNotificationTransports()) === false) {
            return $feedback->getNotificationTransports();
        }

        return ['mail'];
    }

    /**
     * @param Feedback $feedback
     * @return Mailable
     */
    public function toMail(Feedback $feedback)
    {
        return (new Mailable($feedback));
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
