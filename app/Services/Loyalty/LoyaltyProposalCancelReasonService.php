<?php

namespace App\Services\Loyalty;

use App\Services\BaseService;
use App\Domain\ServiceContracts\Loyalty\LoyaltyProposalCancelReasonServiceContract;
use App\Domain\Repositories\Loyalty\LoyaltyProposalCancelReasonRepositoryContract;
use App\Http\Resources\Loyalty\LoyaltyProposalCancelReasonResource;

/**
 * Class LoyaltyProposalCancelReasonService
 * @package App\Services\Loyalty
 */
class LoyaltyProposalCancelReasonService extends BaseService implements LoyaltyProposalCancelReasonServiceContract
{
    /**
     * @var LoyaltyProposalCancelReasonRepositoryContract
     */
    private $repository;

    /**
     * LoyaltyProposalCancelReasonService constructor.
     * @param LoyaltyProposalCancelReasonRepositoryContract $repository
     */
    public function __construct(LoyaltyProposalCancelReasonRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return LoyaltyProposalCancelReasonRepositoryContract
     */
    public function getRepository(): LoyaltyProposalCancelReasonRepositoryContract
    {
        return $this->repository;
    }

    /**
     * @param array $params
     * @return LoyaltyProposalCancelReasonResource
     */
    public function createProposalCancelReason(array $params = []): LoyaltyProposalCancelReasonResource
    {
        $certificate = $this->repository->getSource()::create($params);

        return LoyaltyProposalCancelReasonResource::make($certificate);
    }
}
