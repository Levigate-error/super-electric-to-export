<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\ExternalEntity;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Utils\Synchronizations\SynchronizationManager;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * Class SalesForceUserJob
 * @package App\Jobs
 */
class SalesForceUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var int
     */
    public $tries = 3;

    /**
     * @var int
     */
    public $retryAfter = 3;

    /**
     * SalesForceUserJob constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $provider = (new SynchronizationManager(app()))->driver('SalesForce');
        $externalUserModel = $this->user->externalEntityBySystem('SalesForce');

        if ($externalUserModel !== null) {
            $provider->updateElectrician($externalUserModel['external_id'], [
                'LastName' => $this->user->last_name,
                'FirstName' => $this->user->first_name,
                'Phone' => $this->user->phone,
                'PersonEmail' => $this->user->email,
                'BillingCity' => $this->user->cityName,
                'ExternalId__c' => $this->user->id,
            ]);
        } else {
            $externalUser = $provider->addElectrician([
                'LastName' => $this->user->last_name,
                'FirstName' => $this->user->first_name,
                'Phone' => $this->user->phone,
                'PersonEmail' => $this->user->email,
                'BillingCity' => $this->user->cityName,
                'ExternalId__c' => $this->user->id,
            ]);

            $externalEntity = new ExternalEntity([
                'source_id' => $this->user->id,
                'external_id' => $externalUser['id'],
                'source_type' => User::class,
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
        Log::channel('sales-force')->warning('SalesForceUserJob', [
            'error' => $exception->getMessage()
        ]);
    }
}
