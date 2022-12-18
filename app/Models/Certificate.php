<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Certificate
 * @package App\Models
 */
class Certificate extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['code', 'active'];

    /**
     * @return HasOne
     */
    public function loyaltyUser(): HasOne
    {
        return $this->hasOne(LoyaltyUser::class);
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
