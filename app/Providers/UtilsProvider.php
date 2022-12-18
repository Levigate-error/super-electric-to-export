<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\UtilContracts\Files\FilesManagerContract;
use App\Utils\Files\FilesManager;
use App\Domain\UtilContracts\Files\FilesProviderFactoryContract;
use App\Utils\Files\FilesProviderFactory;

/**
 * Class UtilsProvider
 *
 * @package App\Providers
 */
class UtilsProvider extends ServiceProvider
{
    /**
     * @var array
     */
    public $singletons = [
        FilesManagerContract::class         => FilesManager::class,
        FilesProviderFactoryContract::class => FilesProviderFactory::class,
    ];
}
