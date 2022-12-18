<?php

namespace App\Observers;

use App\Models\Project\Project;
use App\Jobs\SalesForceProjectJob;

/**
 * Class ProjectObserver
 * @package App\Observers
 */
class ProjectObserver
{
    /**
     * @param Project $project
     */
    public function created(Project $project): void
    {
        SalesForceProjectJob::dispatch($project);
    }

    /**
     * @param Project $project
     */
    public function updated(Project $project): void
    {
        SalesForceProjectJob::dispatch($project);
    }
}
