<?php

namespace App\Jobs;

use App\Models\Project\Project;
use App\Models\ExternalEntity;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Utils\Synchronizations\SynchronizationManager;
use Illuminate\Support\Facades\Log;
use App\Exceptions\NotFoundException;
use Exception;

/**
 * Class SalesForceProjectJob
 * @package App\Jobs
 */
class SalesForceProjectJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Project
     */
    protected $project;

    /**
     * @var int
     */
    public $tries = 3;

    /**
     * @var int
     */
    public $retryAfter = 3;

    /**
     * SalesForceProjectJob constructor.
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        /**
         * Проект может быть создан не авторизованым пользователем.
         * Тогда не нужно отправлять
         */
        if ($this->project->user === null) {
            return;
        }

        $externalUser = $this->project->user->externalEntityBySystem('SalesForce');

        if ($externalUser === null) {
            throw new NotFoundException('External entity not found. User ID: ' . $this->project->user->id);
        }

        $provider = (new SynchronizationManager(app()))->driver('SalesForce');
        $externalProjectModel = $this->project->externalEntityBySystem('SalesForce');

        if ($externalProjectModel !== null) {
            $provider->updateProject($externalProjectModel['external_id'], [
                'Name' => $this->project->title ?? $this->project->id,
                'ExternalId__c' => $this->project->id,
                'StageName' => !empty($this->project->status) ? $this->project->status->selfTranslate()->title : 'new',
                'Accountid' => $externalUser->external_id,
            ]);
        } else {
            $externalProject = $provider->addProject([
                'Name' => $this->project->title ?? $this->project->id,
                'ExternalId__c' => $this->project->id,
                'StageName' => !empty($this->project->status) ? $this->project->status->selfTranslate()->title : 'new',
                'CloseDate' => time(),
                'Accountid' => $externalUser->external_id,
            ]);

            $externalEntity = new ExternalEntity([
                'source_id' => $this->project->id,
                'external_id' => $externalProject['id'],
                'source_type' => Project::class,
                'system' => $provider->getProviderCode(),
            ]);
            $externalEntity->trySaveModel();
        }
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception): void
    {
        Log::channel('sales-force')->warning('SalesForceProjectJob', [
            'error' => $exception->getMessage()
        ]);
    }
}
