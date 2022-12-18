<?php

namespace App\Models\Project;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Traits\Translatable;

/**
 * Class ProjectAttributeValue
 * @package App\Models
 */
class ProjectAttributeValue extends BaseModel
{
    use Translatable;

    /**
     * @var array
     */
    protected $translatableFields = ['title'];

    /**
     * @return HasOne
     */
    public function attribute(): HasOne
    {
        return $this->hasOne(ProjectAttribute::class, 'id', 'project_attribute_id');
    }

    /**
     * @return HasMany
     */
    public function projectsAttributes(): HasMany
    {
        return $this->hasMany(ProjectAttributesProject::class, 'project_attribute_value_id')->orderBy('id', 'desc');
    }
}
