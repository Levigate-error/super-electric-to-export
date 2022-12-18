<?php

namespace App\Notifications;

/**
 * Trait HasNotificationTransport
 * @package Illuminate\Notifications
 */
trait HasNotificationTransport
{
    /**
     * @return array|null
     */
    public function getNotificationTransports(): ?array
    {
        if (empty($this->notificationTransports) === false) {
            return $this->notificationTransports;
        }

        return [config('notification.transport')];
    }
}
