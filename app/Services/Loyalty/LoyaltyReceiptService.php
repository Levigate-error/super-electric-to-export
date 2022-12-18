<?php

namespace App\Services\Loyalty;

use App\Domain\Dictionaries\Loyalty\LoyaltyReceiptsReviewStatuses;
use App\Models\Loyalty\LoyaltyReceipt;
use App\Services\BaseService;
use App\Models\Image;
use App\Domain\Repositories\Loyalty\LoyaltyReceiptRepositoryContract;
use App\Domain\ServiceContracts\Loyalty\LoyaltyReceiptServiceContract;
use App\Http\Resources\Loyalty\LoyaltyReceiptResource;
use Illuminate\Http\UploadedFile;
use App\Domain\Dictionaries\Loyalty\LoyaltyReceiptsStatuses;
use App\Jobs\BeatleReceiptJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * Class LoyaltyUserPointService
 * @package App\Services\Loyalty
 */
class LoyaltyReceiptService extends BaseService implements LoyaltyReceiptServiceContract
{
    /**
     * @var LoyaltyReceiptRepositoryContract
     */
    private $repository;

    /**
     * LoyaltyReceiptService constructor.
     * @param LoyaltyReceiptRepositoryContract $repository
     */
    public function __construct(LoyaltyReceiptRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return LoyaltyReceiptRepositoryContract
     */
    public function getRepository(): LoyaltyReceiptRepositoryContract
    {
        return $this->repository;
    }

    /**
     * @param array $params
     * @return LoyaltyReceiptResource
     */
    public function uploadReceipt(array $params = []): LoyaltyReceiptResource
    {
        $loyaltyReceipt = LoyaltyReceipt::where([
            'loyalty_user_id' => $params['loyalty_user_id'],
            'coupon_code' => $params['coupon_code'],
            'status_id' => LoyaltyReceiptsStatuses::UNPROCESSED,
            'review_status_id' => LoyaltyReceiptsReviewStatuses::NEW,
        ])->first();

        foreach ($params['receipts'] as $receipt) {
            $path = $this->generateReceiptPath($receipt);
            Storage::disk('public')->put($path, $receipt->get());

            $images[] = new Image([
                'size' => $receipt->getSize(),
                'path' => $path
            ]);
        }

        $loyaltyReceipt->images()->saveMany($images);
        BeatleReceiptJob::dispatch($loyaltyReceipt);

        return LoyaltyReceiptResource::make($loyaltyReceipt);
    }

    /**
     * @param array $params
     * @return LoyaltyReceiptResource
     */
    public function uploadReceiptManually(array $params = []): LoyaltyReceiptResource
    {

        $params['receipt_datetime'] = date('m/d/Y H:i', strtotime($params['receipt_datetime']));//Carbon::createFromFormat('m/d/Y H:i', $params['receipt_datetime']);
        $params['status_id'] = LoyaltyReceiptsStatuses::UNPROCESSED;
        $params['review_status_id'] = LoyaltyReceiptsReviewStatuses::NEW;

        $loyaltyReceipt = $this->repository->getSource()::create($params);
        BeatleReceiptJob::dispatch($loyaltyReceipt);
        return LoyaltyReceiptResource::make($loyaltyReceipt);
    }


    /**
     * @param UploadedFile $file
     * @return string
     */
    private function generateReceiptPath(UploadedFile $file): string
    {
        return 'receipt' . time() . '_' . $file->getBasename() . '.' . $file->getClientOriginalExtension();
    }

    /**
     * @return array
     */
    public function getLoyaltyReceiptsByUser(): array
    {
        if (Auth::user() === null) {
            return [];
        }

        $userLoyalties = $this->repository->getLoyaltyReceiptsByUserId(Auth::user()->id);

        return LoyaltyReceiptResource::collection($userLoyalties->untype())->resolve();
    }

    /**
     * @return float
     */
    public function getLoyaltyReceiptsTotalAmountByUser(): float
    {
        if (Auth::user() === null) {
            return 0;
        }

        return $this->repository->getLoyaltyReceiptsTotalAmountByUserId(Auth::user()->id);
    }
}
