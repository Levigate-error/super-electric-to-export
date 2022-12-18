<?php

namespace App\Services\Loyalty;

use App\Domain\ServiceContracts\User\UserServiceContract;
use App\Exceptions\CanNotSaveException;
use App\Http\Resources\Loyalty\LoyaltyResource;
use App\Http\Resources\Loyalty\LoyaltyUserProposalResource;
use App\Services\BaseService;
use App\Domain\ServiceContracts\Loyalty\LoyaltyServiceContract;
use App\Domain\ServiceContracts\Loyalty\LoyaltyReceiptServiceContract;
use App\Domain\ServiceContracts\CertificateServiceContract;
use App\Domain\ServiceContracts\Loyalty\LoyaltyUserServiceContract;
use App\Domain\ServiceContracts\Loyalty\LoyaltyUserProposalServiceContract;
use App\Domain\Repositories\Loyalty\LoyaltyRepositoryContract;
use App\Validators\User\UserProfileCompletenessValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\WrongArgumentException;
use Illuminate\Support\Facades\DB;

/**
 * Class LoyaltyService
 * @package App\Services\Loyalty
 */
class LoyaltyService extends BaseService implements LoyaltyServiceContract
{
    /**
     * @var LoyaltyRepositoryContract
     */
    private $repository;

    /**
     * @var CertificateServiceContract
     */
    private $certificateService;

    /**
     * @var LoyaltyUserServiceContract
     */
    private $loyaltyUserService;

    /**
     * @var LoyaltyUserProposalServiceContract
     */
    private $userProposalService;

    /**
     * @var UserServiceContract
     */
    private $userService;

    /**
     * @var LoyaltyReceiptServiceContract
     */
    private $loyaltyReceiptService;


    /**
     * LoyaltyService constructor.
     * @param  LoyaltyRepositoryContract  $repository
     * @param  CertificateServiceContract  $certificateService
     * @param  LoyaltyUserServiceContract  $loyaltyUserService
     * @param  LoyaltyUserProposalServiceContract  $userProposalService
     * @param  UserServiceContract  $userService
     */
    public function __construct(
        LoyaltyRepositoryContract $repository,
        CertificateServiceContract $certificateService,
        LoyaltyUserServiceContract $loyaltyUserService,
        LoyaltyUserProposalServiceContract $userProposalService,
        UserServiceContract $userService,
        LoyaltyReceiptServiceContract $loyaltyReceiptService
    ) {
        $this->repository = $repository;
        $this->certificateService = $certificateService;
        $this->loyaltyUserService = $loyaltyUserService;
        $this->userProposalService = $userProposalService;
        $this->userService = $userService;
        $this->loyaltyReceiptService = $loyaltyReceiptService;
    }

    /**
     * @return LoyaltyRepositoryContract
     */
    public function getRepository(): LoyaltyRepositoryContract
    {
        return $this->repository;
    }

    /**
     * @param array $params
     * @return array
     */
    public function createLoyalty(array $params = []): array
    {
        $loyalty = $this->repository->getSource()::create($params);

        return LoyaltyResource::make($loyalty)->resolve();
    }

    /**
     * @param array $params
     * @return array
     */
    public function getLoyaltyList(array $params = []): array
    {
        $loyalties = $this->repository->getLoyaltyList($params);

        return LoyaltyResource::collection($loyalties->untype())->resolve();
    }

    /**
     * @param  array  $params
     * @return array
     */
    public function registerUser(array $params): array
    {
        $code = $params['code'];
        $loyaltyId = $params['loyalty_id'];
        $userId = Auth::user()->id;

        $this->registerAbilityCheck($userId, $loyaltyId, $code);

        $certificate = $this->certificateService->getCertificateByCode($code);

        DB::beginTransaction();

        $loyaltyUserResource = $this->loyaltyUserService->registerUser($loyaltyId, $userId, $certificate->resource->id);

        $userParams = [
            'published' => true,
        ];
        if ($this->userService->updateUserProfile($userId, $userParams) === false) {
            throw new CanNotSaveException();
        }

        DB::commit();

        return $loyaltyUserResource->resolve();
    }

    /**
     * @param  int  $userId
     * @param  int  $loyaltyId
     * @param  string  $code
     */
    protected function registerAbilityCheck(int $userId, int $loyaltyId, string $code): void
    {
        $validator = new UserProfileCompletenessValidator();

        $checkErrors = $this->userService->checkUserDataCompleteness($userId, $validator);
        if ($checkErrors->isNotEmpty() === true) {
            throw new WrongArgumentException($checkErrors->first()['errors']);
        }

        if ($this->loyaltyUserService->checkSameRegister($loyaltyId, $userId) === true) {
            throw new WrongArgumentException(trans('loyalty-program.errors.user_already_register'));
        }

        if ($this->certificateService->checkCertificate($code) === false) {
            throw new WrongArgumentException(trans('loyalty-program.errors.code_already_register_or_not_found'));
        }
    }

    /**
     * @param array $params
     * @return array
     */
    public function registerProductCode(array $params): array
    {
        $code = $params['code'];
        $loyaltyId = $params['loyalty_id'];
        $userId = Auth::user()->id;

        $loyaltyUser = $this->loyaltyUserService->getFirstLoyaltyUserOrRegisterByParams($loyaltyId, $userId);

        return $this->userProposalService->registerProposal($loyaltyUser->loyaltyUserPoint->id, $code)->resolve();
    }

    /**
     * @param int $loyaltyId
     * @return array
     */
    public function getCurrentUserProposalsList(int $loyaltyId): array
    {
        $userId = Auth::user()->id;

        if ($this->loyaltyUserService->checkUserRegisterInLoyalty($loyaltyId, $userId) === false) {
            throw new WrongArgumentException(trans('loyalty-program.errors.user_not_register'));
        }

        $userProposals = $this->loyaltyUserService->getFirstLoyaltyUserByParams([
            'loyalty_id' => $loyaltyId,
            'user_id' => $userId,
        ])->resource->loyaltyUserPoint->loyaltyUserProposals;

        return LoyaltyUserProposalResource::collection($userProposals->untype())->resolve();
    }

    /**
     * @param array $params
     * @return array
     */
    public function uploadReceipt(array $params): array
    {
        $params['loyalty_user_id'] = $this->getInspiriaLoyaltyUserId();

        return $this->loyaltyReceiptService->uploadReceipt($params)->resolve();
    }

    public function uploadReceiptManually(array $params): array
    {
        $params['loyalty_user_id'] = $this->getInspiriaLoyaltyUserId();

        return $this->loyaltyReceiptService->uploadReceiptManually($params)->resolve();
    }

    public function getLoyaltyReceiptsByUser(): array
    {
        return $this->loyaltyReceiptService->getLoyaltyReceiptsByUser();
    }

    public function getLoyaltyReceiptsTotalAmountByUserId(): float
    {
        return $this->loyaltyReceiptService->getLoyaltyReceiptsTotalAmountByUser();
    }

    private function getInspiriaLoyaltyUserId()
    {
        $loyalty = $this->repository->getInspiria();
        if (is_null($loyalty))
        {
            throw new WrongArgumentException(__('loyalty-program.inspiria-not-found'));
        }
        $loyaltyId = $loyalty->id;
        $userId = Auth::id();

        $loyaltyUser = $this->loyaltyUserService->getInspiriaLoyaltyUserByParams([
            'loyalty_id' => $loyaltyId,
            'user_id' => $userId,
        ]);

        return $loyaltyUser->id;
    }

    public function getLoyaltyProgramId()
    {
        return $this->repository->getLoyaltyIdByTitle('Стань суперэлектриком with Netatmo 2.1');
    }
}
