<?php

namespace App\Models\Loyalty;

use App\Collections\Loyalty\LoyaltyUserCategoryCollection;
use App\Models\BaseModel;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\URL;

/**
 * Class LoyaltyUserCategory
 * @package App\Models\Loyalty
 */
class LoyaltyUserCategory extends BaseModel
{
    use Translatable;

    public const ICON_PATH = 'images' . DIRECTORY_SEPARATOR . 'loyalty_user_categories' . DIRECTORY_SEPARATOR;

    /**
     * @var array
     */
    protected $translatableFields = ['title'];

    /**
     * @var array
     */
    protected $fillable = ['title', 'icon', 'points'];

    /**
     * @param array $models
     * @return LoyaltyUserCategoryCollection
     */
    public function newCollection(array $models = []): LoyaltyUserCategoryCollection
    {
        return new LoyaltyUserCategoryCollection($models);
    }

    /**
     * @return HasMany
     */
    public function loyaltyUsers(): HasMany
    {
        return $this->hasMany(LoyaltyUser::class);
    }

    /**
     * @return string
     */
    public function getIconWithPathAttribute(): string
    {
        return URL::to(static::ICON_PATH . $this->icon);
    }
}
