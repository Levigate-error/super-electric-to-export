<?php

namespace App\Collections;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Project\Project;

/**
 * Class ProjectCollection
 * @package App\Collections
 */
class ProjectCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [Project::class];
}
