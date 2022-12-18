<?php

namespace App\Models\Project;

use App\Models\BaseModel;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class ProjectProductCategory
 * @package App\Models
 */
class ProjectProductCategory extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['project_id', 'product_category_id'];

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
    public function productCategory(): HasOne
    {
        return $this->hasOne(ProductCategory::class,'id',  'product_category_id');
    }
}
