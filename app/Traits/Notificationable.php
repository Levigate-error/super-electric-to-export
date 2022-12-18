<?php

namespace App\Traits;

/**
 * Trait Notificationable
 * @package App\Traits
 */
trait Notificationable
{
    /**
     * @param string $classMainTitle
     * @param string $classIdentification
     * @return bool
     */
    protected function isNotificationExist(string $classMainTitle, string $classIdentification): bool
    {
        $notificationClassName = $this->getNotificationClassName($classMainTitle, $classIdentification);

        return class_exists($notificationClassName);
    }

    /**
     * @param string $classMainTitle
     * @param string $classIdentification
     * @return string
     */
    protected function getNotificationClassName(string $classMainTitle, string $classIdentification): string
    {
        return 'App\\Notifications\\' . $classMainTitle . ucfirst($classIdentification) . 'Notification';
    }
}
