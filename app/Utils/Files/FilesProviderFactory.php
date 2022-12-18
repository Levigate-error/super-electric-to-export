<?php

namespace App\Utils\Files;

use App\Exceptions\WrongArgumentException;
use App\Domain\UtilContracts\Files\FilesProviderFactoryContract;
use App\Domain\UtilContracts\Files\FilesProviderContract;

/**
 * Class FilesProviderFactory
 * @package App\Utils\Files
 */
class FilesProviderFactory implements FilesProviderFactoryContract
{
    /**
     * @param string $name
     * @param array $config
     * @return FilesProviderContract
     */
    public function make (string $name, array $config): FilesProviderContract
    {
        list($type, $format) = explode('.', $name);

        $provider = "App\\Utils\\Files\\Providers\\" . ucfirst($type) . "\\" . ucfirst($format) . "Provider";

        if (!class_exists($provider)) {
            throw new WrongArgumentException("Provider [$provider] not found.");
        }

        return new $provider($config);
    }
}
