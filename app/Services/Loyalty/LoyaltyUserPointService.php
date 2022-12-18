<?php

namespace App\Services\Loyalty;

use App\Services\BaseService;
use App\Domain\ServiceContracts\Loyalty\LoyaltyUserPointServiceContract;
use App\Domain\ServiceContracts\Loyalty\LoyaltyUserProposalServiceContract;
use App\Domain\Repositories\Loyalty\LoyaltyUserPointRepositoryContract;
use Illuminate\Support\Facades\DB;
use App\Collections\Loyalty\LoyaltyUserPointCollection;

/**
 * Class LoyaltyUserPointService
 * @package App\Services\Loyalty
 */
class LoyaltyUserPointService extends BaseService implements LoyaltyUserPointServiceContract
{
    /**
     * @var LoyaltyUserPointRepositoryContract
     */
    private $repository;

    /**
     * @var LoyaltyUserProposalServiceContract
     */
    private $userProposalService;

    /**
     * LoyaltyUserPointService constructor.
     * @param LoyaltyUserPointRepositoryContract $repository
     * @param LoyaltyUserProposalServiceContract $userProposalService
     */
    public function __construct(LoyaltyUserPointRepositoryContract $repository,
                                LoyaltyUserProposalServiceContract $userProposalService)
    {
        $this->repository = $repository;
        $this->userProposalService = $userProposalService;
    }

    /**
     * @return LoyaltyUserPointRepositoryContract
     */
    public function getRepository(): LoyaltyUserPointRepositoryContract
    {
        return $this->repository;
    }

    /**
     * @param int $userPointId
     * @return bool
     */
    public function reCalcPoints(int $userPointId): bool
    {
        $userPoint = $this->repository->getUserPoint($userPointId);

        $userPoint->points = $this->userProposalService->getProposalsPoints($userPoint->loyaltyUserProposals);

        return $userPoint->trySaveModel();
    }

    /**
     * @param int $userPointId
     * @return bool
     */
    public function setLastPlace(int $userPointId): bool
    {
        $userPoint = $this->repository->getUserPoint($userPointId);

        $loyaltyUsersPoints = $this->repository->getLoyaltyUsersPoints($userPoint->loyaltyUser->loyalty_id);
        $pointsGap = $this->getPointsGap($userPoint->points, $loyaltyUsersPoints);

        return $this->setPlaceAndPointsGap($userPointId, $loyaltyUsersPoints->count(), $pointsGap);
    }

    /**
     * @param int $userPoints
     * @param LoyaltyUserPointCollection $loyaltyUsersPoints
     * @return int
     */
    public function getPointsGap(int $userPoints, LoyaltyUserPointCollection $loyaltyUsersPoints): int
    {
        $maxPoints = $userPoints;

        if ($loyaltyUsersPoints->isNotEmpty() === true) {
            $maxPoints = $loyaltyUsersPoints->first()->points;
        }

        return $maxPoints - $userPoints;
    }

    /**
     * @param int $userPointId
     * @param int $place
     * @param int $pointsGap
     * @return bool
     */
    public function setPlaceAndPointsGap(int $userPointId, int $place, int $pointsGap): bool
    {
        return $this->repository->getSource()::setUserPointPlaceAndGap($userPointId, $place, $pointsGap);
    }

    /**
     * @param int $loyaltyId
     * @return bool
     */
    public function reCalcUsersPointsAndPlaces(int $loyaltyId): bool
    {
        $loyaltyUsersPoints = $this->repository->getLoyaltyUsersPoints($loyaltyId);

        DB::beginTransaction();

        foreach ($loyaltyUsersPoints as $key => $value) {
            $pointsGap = $this->getPointsGap($value->points, $loyaltyUsersPoints);
            $this->setPlaceAndPointsGap($value->id, $key + 1, $pointsGap);
        }

        DB::commit();

        return true;
    }
}
