<?php

namespace App\Domain\UtilContracts\Files;

/**
 * Interface FilesProviderFactoryContract
 * @package App\Domain\UtilContracts\Files
 */
interface FilesProviderFactoryContract
{
    /**
     * @param string $name
     * @param array $config
     * @return FilesProviderContract
     */
    public function make(string $name, array $config): FilesProviderContract;
}
