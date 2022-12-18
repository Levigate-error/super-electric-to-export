<?php

namespace App\Domain\UtilContracts\Files;

/**
 * Interface FilesManagerContract
 * @package App\Domain\UtilContracts\Files
 */
interface FilesManagerContract
{
    /**
     * @param string|null $name
     * @return FilesProviderContract
     */
    public function provider(string $name = null): FilesProviderContract;

    /**
     * @return string
     */
    public function getDefaultProviderName(): string;

    /**
     * @param string $name
     * @return FilesProviderContract
     */
    public function makeProvider(string $name): FilesProviderContract;

    /**
     * @param string $name
     * @return array
     */
    public function configuration(string $name): array;

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $method, array $arguments);
}
