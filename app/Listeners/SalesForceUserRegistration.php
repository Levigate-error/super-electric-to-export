<?php

namespace App\Listeners;

use App\Jobs\SalesForceUserJob;
use Illuminate\Auth\Events\Verified;

/**
 * Class SalesForceUserRegistration
 * @package App\Listeners
 */
class SalesForceUserRegistration
{
    /**
     * @param Verified $event
     */
    public function handle(Verified $event): void
    {
        SalesForceUserJob::dispatch($event->user);
    }
}
