<?php

namespace App\Observers;

use App\Domain\ServiceContracts\Loyalty\LoyaltyServiceContract;
use App\Domain\ServiceContracts\Loyalty\LoyaltyUserPointServiceContract;
use App\Models\User;

/**
 * Class UserObserver
 * @package App\Observers
 */
class UserObserver
{
    /**
     * @var LoyaltyServiceContract
     */
    protected $loyaltyService;

    /**
     * @var LoyaltyUserPointServiceContract
     */
    protected $userPointService;

    /**
     * UserObserver constructor.
     * @param  LoyaltyServiceContract  $loyaltyService
     * @param  LoyaltyUserPointServiceContract  $userPointService
     */
    public function __construct(LoyaltyServiceContract $loyaltyService, LoyaltyUserPointServiceContract $userPointService)
    {
        $this->loyaltyService = $loyaltyService;
        $this->userPointService = $userPointService;
    }

    /**
     * @param User $user
     */
    public function updated(User $user): void
    {
        /**
         * Включить как дадут ответ
         */
        //SalesForceUserJob::dispatch($user);
    }

    public function deleted(): void
    {
        $loyalties = $this->loyaltyService->getLoyaltyList();

        foreach ($loyalties as $loyalty) {
            $this->userPointService->reCalcUsersPointsAndPlaces($loyalty['id']);
        }
    }
}
