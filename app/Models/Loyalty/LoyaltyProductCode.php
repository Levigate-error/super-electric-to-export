<?php

namespace App\Models\Loyalty;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class LoyaltyProductCode
 * @package App\Models\Loyalty
 */
class LoyaltyProductCode extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['code', 'active'];

    /**
     * @return HasOne
     */
    public function loyaltyUserProposal(): HasOne
    {
        return $this->hasOne(LoyaltyUserProposal::class);
    }

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

    /**
     * @param bool $active
     * @return bool
     */
    public function setActive(bool $active): bool
    {
        $this->active = $active;
        return $this->trySaveModel();
    }
}
