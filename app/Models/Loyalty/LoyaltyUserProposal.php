<?php

namespace App\Models\Loyalty;

use App\Collections\Loyalty\LoyaltyUserProposalCollection;
use App\Domain\Dictionaries\Loyalty\LoyaltyUserProposalStatuses;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use App\Notifications\HasNotificationTransport;

/**
 * Class LoyaltyUserProposal
 * @package App\Models\Loyalty
 */
class LoyaltyUserProposal extends BaseModel
{
    use Notifiable;
    use HasNotificationTransport;

    /**
     * @var array
     */
    protected $fillable = [
        'points', 'loyalty_user_point_id', 'loyalty_product_code_id', 'loyalty_proposal_cancel_reason_id',
        'proposal_status', 'code',
    ];

    /**
     * @param array $models
     * @return LoyaltyUserProposalCollection
     */
    public function newCollection(array $models = []): LoyaltyUserProposalCollection
    {
        return new LoyaltyUserProposalCollection($models);
    }

    /**
     * @return belongsTo
     */
    public function loyaltyProductCode(): belongsTo
    {
        return $this->belongsTo(LoyaltyProductCode::class);
    }

    /**
     * @return BelongsTo
     */
    public function loyaltyUserPoint(): BelongsTo
    {
        return $this->belongsTo(LoyaltyUserPoint::class);
    }

    /**
     * @return BelongsTo
     */
    public function loyaltyCancelReason(): BelongsTo
    {
        return $this->belongsTo(LoyaltyProposalCancelReason::class, 'loyalty_proposal_cancel_reason_id');
    }

    /**
     * @return string
     */
    public function getStatusOnHumanAttribute(): string
    {
        return LoyaltyUserProposalStatuses::toHuman($this->proposal_status);
    }

    /**
     * @param  int  $userPointId
     * @param  int|null  $productCodeId
     * @param  string  $code
     * @return static
     */
    public static function registerProposal(int $userPointId, ?int $productCodeId, string $code): self
    {
        $model = new self([
            'points' => LoyaltyUserPoint::getPointPerProductCode(),
            'loyalty_user_point_id' => $userPointId,
            'loyalty_product_code_id' => $productCodeId,
            'proposal_status' => LoyaltyUserProposalStatuses::NEW,
            'code' => $code,
        ]);
        $model->trySaveModel();

        return $model;
    }

    /**
     * @param string $status
     * @return bool
     */
    public function setStatus(string $status): bool
    {
        $this->proposal_status = $status;

        return $this->trySaveModel();
    }

    /**
     * @param int $cancelReason
     * @return bool
     */
    public function setCancelReason(int $cancelReason): bool
    {
        $this->loyalty_proposal_cancel_reason_id = $cancelReason;

        return $this->trySaveModel();
    }

    /**
     * @param  LoyaltyProductCode  $productCode
     * @return bool
     */
    public function setProductCode(LoyaltyProductCode $productCode): bool
    {
        $this->loyaltyProductCode()->associate($productCode);

        if ($this->trySaveModel() === true) {
            return $productCode->setActive(false);
        }

        return false;
    }
}
