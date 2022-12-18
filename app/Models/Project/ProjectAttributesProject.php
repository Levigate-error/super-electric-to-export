<?php

namespace App\Models\Project;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class ProjectAttributesProject
 * @package App\Models
 */
class ProjectAttributesProject extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['project_id', 'project_attribute_id', 'project_attribute_value_id'];

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
    public function attribute(): HasOne
    {
        return $this->hasOne(ProjectAttribute::class, 'id', 'project_attribute_id');
    }

    /**
     * @return HasOne
     */
    public function value(): HasOne
    {
        return $this->hasOne(ProjectAttributeValue::class, 'id', 'project_attribute_value_id');
    }
}
