<?php

namespace App\Services\Loyalty;

use App\Domain\Dictionaries\Loyalty\LoyaltyUserProposalStatuses;
use App\Domain\ServiceContracts\Loyalty\LoyaltyProductCodeServiceContract;
use App\Services\BaseService;
use App\Domain\ServiceContracts\Loyalty\LoyaltyUserProposalServiceContract;
use App\Domain\Repositories\Loyalty\LoyaltyUserProposalRepositoryContract;
use App\Http\Resources\Loyalty\LoyaltyUserProposalResource;
use App\Collections\Loyalty\LoyaltyUserProposalCollection;
use App\Exceptions\WrongArgumentException;

/**
 * Class LoyaltyUserProposalService
 * @package App\Services\Loyalty
 */
class LoyaltyUserProposalService extends BaseService implements LoyaltyUserProposalServiceContract
{
    /**
     * @var LoyaltyUserProposalRepositoryContract
     */
    private $repository;

    /**
     * @var LoyaltyProductCodeServiceContract
     */
    private $productCodeService;

    /**
     * LoyaltyUserProposalService constructor.
     * @param  LoyaltyUserProposalRepositoryContract  $repository
     * @param  LoyaltyProductCodeServiceContract  $productCodeService
     */
    public function __construct(LoyaltyUserProposalRepositoryContract $repository,
        LoyaltyProductCodeServiceContract $productCodeService)
    {
        $this->repository = $repository;
        $this->productCodeService = $productCodeService;
    }

    /**
     * @return LoyaltyUserProposalRepositoryContract
     */
    public function getRepository(): LoyaltyUserProposalRepositoryContract
    {
        return $this->repository;
    }

    /**
     * @param  int  $userPointId
     * @param  string  $code
     * @return LoyaltyUserProposalResource
     */
    public function registerProposal(int $userPointId, string $code): LoyaltyUserProposalResource
    {
        $productCode = $this->productCodeService->getProductCodeByCode($code);
        $productCodeId = null;
        if ($productCode->resource !== null) {
            if ($productCode->resource->active === false) {
                throw new WrongArgumentException(__('loyalty-program.errors.code-already-registered'));
            }
            $productCodeId = $productCode->resource->id;
        }

        $loyaltyProposal = $this->repository->getSource()::registerProposal($userPointId, $productCodeId, $code);

        return LoyaltyUserProposalResource::make($loyaltyProposal);
    }

    /**
     * @param LoyaltyUserProposalCollection $proposals
     * @return int
     */
    public function getProposalsPoints(LoyaltyUserProposalCollection $proposals): int
    {
        return $proposals->sum(static function ($proposal) {
            if ($proposal->proposal_status === LoyaltyUserProposalStatuses::APPROVED) {
                return $proposal->points;
            }
        });
    }

    /**
     * @param string $code
     * @return bool
     */
    public function checkProductCodeUsage(string $code): bool
    {
        $proposal = $this->repository->getProposalByProductCode($code);

        if ($proposal === null) {
            return false;
        }

        return true;
    }
}
