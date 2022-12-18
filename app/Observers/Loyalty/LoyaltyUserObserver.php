<?php

namespace App\Observers\Loyalty;

use App\Models\Loyalty\LoyaltyUser;
use App\Notifications\LoyaltyUserAdminNotification;
use App\Notifications\LoyaltyUserNotification;
use App\Traits\Notificationable;

/**
 * Class LoyaltyUserObserver
 * @package App\Observers\Loyalty
 */
class LoyaltyUserObserver
{
    use Notificationable;

    /**
     * @param LoyaltyUser $loyaltyUser
     */
    public function created(LoyaltyUser $loyaltyUser): void
    {
        if ($loyaltyUser->certificate) {
            $loyaltyUser->certificate->setActive(false);
        }
        $loyaltyUser->loyaltyUserPoint()->create();

        $loyaltyUser->notify(new LoyaltyUserAdminNotification());

        $loyaltyUser->user->notify(new LoyaltyUserNotification());
    }

    /**
     * @param LoyaltyUser $loyaltyUser
     */
    public function updated(LoyaltyUser $loyaltyUser): void
    {
        if ($loyaltyUser->isDirty('status') === true) {
            $newStatus = $loyaltyUser->getChanges()['status'];

            if ($this->isNotificationExist('LoyaltyUser', $newStatus) === true) {
                $notificationClassName = $this->getNotificationClassName('LoyaltyUser', $newStatus);

                $loyaltyUser->user->notify(new $notificationClassName());
            }
        }
    }
}
