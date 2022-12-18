<?php

namespace App\Observers;

use App\Models\Feedback;
use App\Notifications\FeedbackNotification;

/**
 * Class FeedbackObserver
 * @package App\Observers
 */
class FeedbackObserver
{
    /**
     * @param Feedback $feedback
     */
    public function created(Feedback $feedback): void
    {
        $feedback->notify(new FeedbackNotification());

        $feedback->createLogs()->create([
            'ip' => request()->getClientIp(),
            'client' => request()->header('user-agent'),
        ]);
    }
}
