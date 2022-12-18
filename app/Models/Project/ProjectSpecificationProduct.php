<?php

namespace App\Models\Project;

use App\Models\BaseModel;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class ProjectSpecificationProduct
 * @package App\Models
 */
class ProjectSpecificationProduct extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'project_specification_section_id', 'product_id', 'amount', 'project_product_id',
        'price', 'total_price', 'in_stock', 'active', 'discount', 'real_price',
    ];

    /**
     * @return HasOne
     */
    public function specificationSection(): HasOne
    {
        return $this->hasOne(ProjectSpecificationSection::class, 'id', 'project_specification_section_id');
    }

    /**
     * @return HasOne
     */
    public function product(): HasOne
    {
        return $this->hasOne(Product::class,'id',  'product_id');
    }

    /**
     * @return HasOne
     */
    public function projectProduct(): HasOne
    {
        return $this->hasOne(ProjectProduct::class,'id',  'project_product_id');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where(['active' => true]);
    }

    /**
     * @return bool
     */
    public function updatePrice(): bool
    {
        $this->updatePriceWithDiscount();
        $this->updateTotalPrice();

        return $this->saveQuietly();
    }

    public function updateTotalPrice(): void
    {
        $this->total_price = $this->amount * $this->price;
    }

    public function updatePriceWithDiscount(): void
    {
        $newPrice = $this->real_price * (1 - $this->discount/100);
        $this->price = round($newPrice, 2);
    }

    /**
     * @param int $projectSpecificationProductId
     * @param array $params
     * @return bool
     */
    public static function updateProduct(int $projectSpecificationProductId, array $params): bool
    {
        return self::query()
            ->findOrFail($projectSpecificationProductId)
            ->fill($params)
            ->trySaveModel();
    }

    /**
     * @param int $projectSpecificationProductId
     * @return bool
     * @throws \Exception
     */
    public static function deleteProduct(int $projectSpecificationProductId): bool
    {
        $projectSpecificationProduct = self::query()->findOrFail($projectSpecificationProductId);

        return $projectSpecificationProduct->delete();
    }
}
