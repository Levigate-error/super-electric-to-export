<?php

namespace App\Models\Project;

use App\Models\BaseModel;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Traits\HasExternalEntity;

/**
 * Class ProjectProduct
 * @package App\Models
 */
class ProjectProduct extends BaseModel
{
    use HasExternalEntity;

    /**
     * @var array
     */
    protected $fillable = ['project_id', 'product_id', 'amount', 'real_price', 'not_used_amount',
        'in_stock', 'discount', 'active', 'price_with_discount'];

    /**
     * @return HasOne
     */
    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    /**
     * @return HasOne
     */
    public function product(): HasOne
    {
        return $this->hasOne(Product::class,'id',  'product_id');
    }

    /**
     * Пересчет стоимости товары с учетом скидки
     *
     * @return bool
     */
    public function updatePriceWithDiscount(): bool
    {
        $this->price_with_discount = round($this->real_price * (1 - $this->discount/100), 2);

        return $this->saveQuietly();
    }
}
