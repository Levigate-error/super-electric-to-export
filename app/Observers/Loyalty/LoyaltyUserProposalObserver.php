<?php

namespace App\Observers\Loyalty;

use App\Models\Loyalty\LoyaltyUserProposal;
use App\Domain\ServiceContracts\Loyalty\LoyaltyUserPointServiceContract;
use App\Notifications\LoyaltyUserProposalAdminNotification;
use App\Notifications\LoyaltyUserProposalNotification;
use App\Traits\Notificationable;

/**
 * Class LoyaltyUserProposalObserver
 * @package App\Observers\Loyalty
 */
class LoyaltyUserProposalObserver
{
    use Notificationable;

    /**
     * @var LoyaltyUserPointServiceContract
     */
    private $userPointService;

    /**
     * LoyaltyUserProposalObserver constructor.
     * @param LoyaltyUserPointServiceContract $userPointService
     */
    public function __construct(LoyaltyUserPointServiceContract $userPointService)
    {
        $this->userPointService = $userPointService;
    }

    /**
     * @param LoyaltyUserProposal $proposal
     */
    public function created(LoyaltyUserProposal $proposal): void
    {
        if ($proposal->loyaltyProductCode !== null) {
            $proposal->loyaltyProductCode->setActive(false);
        }

        $this->userPointService->reCalcPoints($proposal->loyaltyUserPoint->id);

        $proposal->notify(new LoyaltyUserProposalAdminNotification());

        $proposal->loyaltyUserPoint->loyaltyUser->user->notify(new LoyaltyUserProposalNotification());
    }

    /**
     * @param LoyaltyUserProposal $proposal
     */
    public function updated(LoyaltyUserProposal $proposal): void
    {
        $this->userPointService->reCalcPoints($proposal->loyaltyUserPoint->id);

        if ($proposal->isDirty('proposal_status') === true) {
            $newStatus = $proposal->getChanges()['proposal_status'];

            if ($this->isNotificationExist('LoyaltyUserProposal', $newStatus) === true) {
                $notificationClassName = $this->getNotificationClassName('LoyaltyUserProposal', $newStatus);

                $proposal->loyaltyUserPoint->loyaltyUser->user->notify(new $notificationClassName($proposal));
            }
        }

        if ($proposal->isDirty('accrue_points'))
        {
            $loyaltyUserPoint = $proposal->loyaltyUserPoint;
            $loyaltyUserPoint->points -= $proposal->getOriginal('accrue_points', 0);
            $loyaltyUserPoint->points += $proposal->accrue_points;
            $loyaltyUserPoint->save();
        }
    }

    /**
     * @param LoyaltyUserProposal $proposal
     */
    public function deleted(LoyaltyUserProposal $proposal): void
    {
        $this->userPointService->reCalcPoints($proposal->loyaltyUserPoint->id);
    }
}
