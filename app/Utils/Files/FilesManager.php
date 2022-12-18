<?php

namespace App\Utils\Files;

use App\Exceptions\WrongArgumentException;
use Illuminate\Support\Arr;
use App\Domain\UtilContracts\Files\FilesManagerContract;
use App\Domain\UtilContracts\Files\FilesProviderFactoryContract;
use App\Domain\UtilContracts\Files\FilesProviderContract;

/**
 * Class FilesManager
 * @package App\Utils\Files
 */
class FilesManager implements FilesManagerContract
{
    /**
     * @var FilesProviderFactoryContract
     */
    protected $factory;

    /**
     * @var array
     */
    protected $providers;

    /**
     * @var array
     */
    protected $config;

    /**
     * FilesManager constructor.
     * @param FilesProviderFactoryContract $factory
     */
    public function __construct(FilesProviderFactoryContract $factory)
    {
        $this->factory = $factory;
        $this->config = config('projects');
    }

    /**
     * @param string|null $name
     * @return FilesProviderContract
     */
    public function provider(string $name = null): FilesProviderContract
    {
        $name = $name ?: $this->getDefaultProviderName();

        if (!isset($this->providers[$name])) {
            $this->providers[$name] = $this->makeProvider($name);
        }

        return $this->providers[$name];
    }

    /**
     * @return string
     */
    public function getDefaultProviderName(): string
    {
        return $this->config['default_files_provider'];
    }

    /**
     * @param string $name
     * @return FilesProviderContract
     */
    public function makeProvider(string $name): FilesProviderContract
    {
        $config = $this->configuration($name);

        return $this->factory->make($name, $config);
    }

    /**
     * @param string $name
     * @return array
     */
    public function configuration(string $name): array
    {
        $locale = app()->getLocale();
        if (!isset($this->config['files_providers'][$locale])) {
            throw new WrongArgumentException("Provider [$name] not configured for [$locale] localization.");
        }

        $providers = $this->config['files_providers'][$locale];

        if (is_null($config = Arr::get($providers, $name))) {
            throw new WrongArgumentException("Provider [$name] not configured.");
        }

        return $config;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $method, array $arguments)
    {
        return $this->provider()->$method(...$arguments);
    }
}
