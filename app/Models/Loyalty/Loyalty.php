<?php

namespace App\Models\Loyalty;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Exception;
use App\Collections\Loyalty\LoyaltyCollection;

/**
 * Class Loyalty
 * @package App\Models\Loyalty
 */
class Loyalty extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['title', 'started_at', 'ended_at', 'active'];

    /**
     * @param array $models
     * @return LoyaltyCollection
     */
    public function newCollection(array $models = []): LoyaltyCollection
    {
        return new LoyaltyCollection($models);
    }

    /**
     * @return HasMany
     */
    public function loyaltyUsers(): HasMany
    {
        return $this->hasMany(LoyaltyUser::class)->orderBy('id', 'desc');
    }

    /**
     * @param $params
     * @return static
     * @throws Exception
     */
    public static function create($params): self
    {
        if (isset($params['started_at']) === false) {
            $params['started_at'] = new Carbon();
        }

        if (isset($params['ended_at']) === false) {
            $params['ended_at'] = (new Carbon($params['started_at']))->addYear();
        }

        $model = new self($params);
        $model->trySaveModel();

        return $model;
    }

    /**
     * @param Builder $query
     * @param bool $active
     * @return Builder
     */
    public function scopeActive(Builder $query, bool $active = true): Builder
    {
        return $query->where([
                'active' => $active,
            ]);
    }
}
