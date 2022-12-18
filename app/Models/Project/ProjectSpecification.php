<?php

namespace App\Models\Project;

use App\Models\BaseModel;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ProjectSpecification
 * @package App\Models
 */
class ProjectSpecification extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['project_id', 'version'];

    /**
     * @return HasOne
     */
    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    /**
     * @return hasMany
     */
    public function specificationSections(): hasMany
    {
        return $this->hasMany(ProjectSpecificationSection::class,'project_specification_id',  'id')->orderBy('title', 'asc');
    }

    /**
     * @return $this
     */
    public function setVersion(): self
    {
        $lastVersion = self::query()->where(['project_id' => $this->project_id])->max('version');
        $this->version = $lastVersion + 1;

        return $this;
    }

    /**
     * @param int $specificationId
     * @param array $params
     * @return BaseModel
     */
    public static function addSection(int $specificationId, array $params): BaseModel
    {
        $specification = self::query()->findOrFail($specificationId);

        return $specification->specificationSections()->create($params);
    }

    /**
     * @param ProjectSpecificationSection $section
     * @param Product $product
     * @param int $amount
     * @return bool
     */
    public static function addProductToSection(ProjectSpecificationSection $section, Product $product, int $amount): bool
    {
        return $section->products()->firstOrNew([
            'product_id' => $product->id,
        ])->fill([
            'amount' => $amount,
            'price' => $product->pivot->real_price,
            'real_price' => $product->pivot->real_price,
            'in_stock' => $product->pivot->in_stock,
            'active' => $product->pivot->active,
            'discount' => $product->pivot->discount,
            'project_product_id' => $product->pivot->id,
        ])->trySaveModel();
    }
}
