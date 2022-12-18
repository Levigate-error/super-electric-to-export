<?php

namespace App\Models\Project;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class ProjectContact
 * @package App\Models
 */
class ProjectContact extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'phone'];

    /**
     * @return HasOne
     */
    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }
}
