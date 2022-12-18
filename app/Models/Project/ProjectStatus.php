<?php

namespace App\Models\Project;

use App\Models\BaseModel;
use App\Models\User;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ProjectStatus
 * @package App\Models
 */
class ProjectStatus extends BaseModel
{
    use Translatable;

    /**
     * @var array
     */
    protected $translatableFields = ['title'];

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return HasMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'project_status_id')->orderBy('title', 'asc');
    }
}
