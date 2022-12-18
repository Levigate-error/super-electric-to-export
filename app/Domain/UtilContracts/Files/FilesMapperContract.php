<?php

namespace App\Domain\UtilContracts\Files;

/**
 * Interface FilesMapperContract
 * @package App\Domain\UtilContracts\Files
 */
interface FilesMapperContract
{
    /**
     * @param string $mapKey
     * @return array
     */
    public function getMap(string $mapKey): array;

    /**
     * @param string $mapKey
     * @param string $value
     * @return string|null
     */
    public function getKeyByValue(string $mapKey, string $value): ?string;
}
