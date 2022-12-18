<?php

namespace App\Utils\Synchronizations;

use Illuminate\Support\Manager;
use App\Exceptions\WrongArgumentException;
use App\Utils\Synchronizations\Beatle\BeatleProvider;
use App\Utils\Synchronizations\SalesForce\SalesForceProvider;

/**
 * Class SynchronizationManager
 * @package App\Utils\Synchronizations
 */
class SynchronizationManager extends Manager
{
    /**
     * @return string|void
     */
    public function getDefaultDriver()
    {
        throw new WrongArgumentException('No default driver was specified.');
    }

    /**
     * @return AbstractProvider
     */
    protected function createSalesForceDriver(): AbstractProvider
    {
        return new SalesForceProvider(config('synchronizations.sales_force'));
    }

    protected function createBeatleDriver(): AbstractProvider
    {
        return new BeatleProvider(config('synchronizations.beatle'));
    }
}
