<?php

namespace App\Models\Loyalty;

use App\Models\BaseModel;

/**
 * Class LoyaltyProposalCancelReason
 * @package App\Models\Loyalty
 */
class LoyaltyProposalCancelReason extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['value'];

    /**
     * @param array $params
     * @return static
     */
    public static function create(array $params): self
    {
        $model = new self($params);
        $model->trySaveModel();

        return $model;
    }
}
