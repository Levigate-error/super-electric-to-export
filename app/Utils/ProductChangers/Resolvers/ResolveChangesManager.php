<?php

namespace App\Utils\ProductChangers\Resolvers;

use Illuminate\Support\Manager;
use App\Exceptions\WrongArgumentException;
use App\Domain\UtilContracts\ProductChangers\Resolvers\Contracts\ProjectProductChangesDriverContract;

class ResolveChangesManager extends Manager
{
    /**
     * @return string|void
     */
    public function getDefaultDriver()
    {
        throw new WrongArgumentException('No default driver was specified.');
    }

    /**
     * @param string $driver
     * @return ProjectProductChangesDriverContract
     */
    protected function createDriver($driver): ProjectProductChangesDriverContract
    {
        $driverName = implode('', array_map('ucfirst', explode('_', $driver))) . 'Driver';
        $driverClass = 'App\\Utils\\ProductChangers\\Resolvers\\Drivers\\' . $driverName;

        if (!class_exists($driverClass)) {
            throw new WrongArgumentException("Driver [$driverClass] not supported.");
        }

        return new $driverClass();
    }
}
