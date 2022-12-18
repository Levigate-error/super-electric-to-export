<?php

namespace App\Models\Project;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Translatable;

/**
 * Class ProjectAttribute
 * @package App\Models
 */
class ProjectAttribute extends BaseModel
{
    use Translatable;

    /**
     * @var array
     */
    protected $translatableFields = ['title'];

    /**
     * @return HasMany
     */
    public function values(): HasMany
    {
        return $this->hasMany(ProjectAttributeValue::class, 'project_attribute_id')->orderBy('id', 'desc');
    }

    /**
     * @return HasMany
     */
    public function projectsAttributes(): HasMany
    {
        return $this->hasMany(ProjectAttributesProject::class, 'project_attribute_id')->orderBy('id', 'desc');
    }
}
