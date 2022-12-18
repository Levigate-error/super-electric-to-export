<?php

namespace App\Observers\Loyalty;

use App\Domain\ServiceContracts\Loyalty\LoyaltyUserPointServiceContract;
use App\Domain\ServiceContracts\Loyalty\LoyaltyUserServiceContract;
use App\Models\Loyalty\LoyaltyUserPoint;

/**
 * Class LoyaltyUserPointObserver
 * @package App\Observers\Loyalty
 */
class LoyaltyUserPointObserver
{
    /**
     * @var LoyaltyUserPointServiceContract
     */
    private $service;

    /**
     * @var LoyaltyUserServiceContract
     */
    private $loyaltyUserService;

    /**
     * LoyaltyUserPointObserver constructor.
     * @param LoyaltyUserPointServiceContract $service
     * @param LoyaltyUserServiceContract $loyaltyUserService
     */
    public function __construct(LoyaltyUserPointServiceContract $service,
                                LoyaltyUserServiceContract $loyaltyUserService)
    {
        $this->service = $service;
        $this->loyaltyUserService = $loyaltyUserService;
    }

    /**
     * @param LoyaltyUserPoint $loyaltyUserPoint
     */
    public function created(LoyaltyUserPoint $loyaltyUserPoint): void
    {
        $this->service->setLastPlace($loyaltyUserPoint->id);
        $this->loyaltyUserService->setUserCategory($loyaltyUserPoint->loyalty_user_id);
    }

    /**
     * @param LoyaltyUserPoint $loyaltyUserPoint
     */
    public function updated(LoyaltyUserPoint $loyaltyUserPoint): void
    {
        $this->service->reCalcUsersPointsAndPlaces($loyaltyUserPoint->loyaltyUser->loyalty_id);
        $this->loyaltyUserService->setUserCategory($loyaltyUserPoint->loyalty_user_id);
    }
}
